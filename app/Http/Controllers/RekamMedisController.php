<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\RekamMedis;
use App\Models\ResepObat;
use App\Models\Obat;
use App\Models\JadwalDokter;

class RekamMedisController extends Controller
{
    // Tampilkan daftar pasien yang statusnya dikonfirmasi untuk hari ini (dokter)
    public function index()
    {
        abort_if(auth()->user()->role !== 'dokter', 403);
        // Tampilkan semua reservasi yang terkait dengan jadwal milik dokter (semua status)
        $dokterId = auth()->user()->id;
        $dokterName = auth()->user()->name;

        // Cari jadwal yang terkait dengan dokter melalui user_id atau nama_dokter
        $jadwalIds = JadwalDokter::where(function($q) use ($dokterId, $dokterName) {
            $q->where('user_id', $dokterId)->orWhere('nama_dokter', $dokterName);
        })->pluck('id')->toArray();

        $reservasis = Reservasi::with(['pasien', 'jadwal'])
            ->whereIn('jadwal_id', $jadwalIds)
            ->where('status', 'dikonfirmasi')
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();

        return view('dokter.rekam.index', compact('reservasis'));
    }

    // Halaman dashboard dokter menampilkan antrean pasien yang sudah disetujui hari ini
    public function dashboard()
    {
        abort_if(auth()->user()->role !== 'dokter', 403);

        try {
            $dokterId = auth()->user()->id;
            $dokterName = auth()->user()->name;
            $today = now()->format('Y-m-d');

            $jadwalIds = JadwalDokter::where(function($q) use ($dokterId, $dokterName) {
                $q->where('user_id', $dokterId)->orWhere('nama_dokter', $dokterName);
            })->pluck('id')->toArray();

            $reservasis = Reservasi::with(['pasien', 'jadwal'])
                ->whereIn('jadwal_id', $jadwalIds)
                ->where('status', 'dikonfirmasi')
                ->where('tanggal_kunjungan', $today)
                ->orderBy('nomor_antrean', 'asc')
                ->get();

            return view('dokter.dashboard', compact('reservasis'));
        } catch (\Exception $e) {
            return view('dokter.dashboard', ['reservasis' => collect()])->with('error', 'Gagal memuat antrean pasien: ' . $e->getMessage());
        }
    }

    // Form untuk membuat rekam medis untuk reservasi tertentu
    public function create($reservasiId)
    {
        abort_if(auth()->user()->role !== 'dokter', 403);

        $reservasi = Reservasi::with(['pasien', 'jadwal'])->findOrFail($reservasiId);

        $dokterId = auth()->user()->id;
        $isOwner = false;
        if ($reservasi->jadwal) {
            $isOwner = ($reservasi->jadwal->user_id === $dokterId) || ($reservasi->jadwal->nama_dokter === auth()->user()->name);
        }

        if (! $isOwner || $reservasi->status !== 'dikonfirmasi') {
            abort(403);
        }

        $obats = Obat::all();
        return view('dokter.rekam.create', compact('reservasi', 'obats'));
    }

    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'dokter', 403);

        $request->validate([
            'reservasi_id' => 'required|exists:reservasis,id',
            'diagnosis' => 'required|string',
            'tindakan' => 'nullable|string',
        ]);

        try {
            $reservasi = Reservasi::with('jadwal')->findOrFail($request->reservasi_id);

            $dokterId = auth()->user()->id;
            $isOwner = false;
            if ($reservasi->jadwal) {
                $isOwner = ($reservasi->jadwal->user_id === $dokterId) || ($reservasi->jadwal->nama_dokter === auth()->user()->name);
            }

            if (! $isOwner || $reservasi->status !== 'dikonfirmasi') {
                abort(403);
            }

            $rekam = RekamMedis::create([
                'reservasi_id' => $reservasi->id,
                'dokter_id' => auth()->user()->id,
                'pasien_id' => $reservasi->pasien_id,
                'diagnosis' => $request->diagnosis,
                'tindakan' => $request->tindakan,
            ]);

            // Simpan resep jika ada
            if ($request->has('obat_id') && is_array($request->obat_id)) {
                foreach ($request->obat_id as $idx => $obatId) {
                    if (empty($obatId)) continue;
                    $jumlah = $request->jumlah[$idx] ?? 1;
                    $aturan = $request->aturan_pakai[$idx] ?? '';

                    ResepObat::create([
                        'rekam_medis_id' => $rekam->id,
                        'obat_id' => $obatId,
                        'jumlah' => $jumlah,
                        'aturan_pakai' => $aturan,
                    ]);
                }
            }

            // Tandai reservasi selesai
            $reservasi->update(['status' => 'selesai']);

            return redirect()->route('dokter.rekam.index')->with('success', 'Rekam medis dan resep berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan rekam medis: ' . $e->getMessage());
        }
    }

    // Tampilkan riwayat rekam medis untuk pasien
    public function riwayatPasien()
    {
        abort_if(auth()->user()->role !== 'pasien', 403);

        $riwayats = RekamMedis::with(['dokter', 'reservasi.jadwal', 'resepObats.obat'])
            ->where('pasien_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pasien.riwayat', compact('riwayats'));
    }

    // Tampilkan detail satu rekam medis untuk pasien
    public function showPasien($id)
    {
        abort_if(auth()->user()->role !== 'pasien', 403);

        $rekam = RekamMedis::with(['dokter', 'reservasi.jadwal', 'resepObats.obat'])
            ->where('pasien_id', auth()->user()->id)
            ->findOrFail($id);

        return view('pasien.riwayat-detail', compact('rekam'));
    }
}
