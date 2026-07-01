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
    // Tampilkan Arsip Rekam Medis untuk dokter
    public function index()
    {
        abort_if(auth()->user()->role !== 'dokter', 403);
        
        $dokterId = auth()->user()->id;
        $dokterName = auth()->user()->name;
        
        $arsip_medis = RekamMedis::whereHas('reservasi.jadwal', function($query) use ($dokterId, $dokterName) {
            $query->where('user_id', $dokterId)->orWhere('nama_dokter', $dokterName);
        })
        ->with(['reservasi.pasien', 'resepObats.obat'])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('dokter.rekam.index', compact('arsip_medis'));
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

        if (! $isOwner || !in_array($reservasi->status, ['pending', 'dikonfirmasi'])) {
            abort(403);
        }

        // Ambil riwayat medis pasien sebelumnya (tidak termasuk reservasi saat ini)
        $riwayat_medis = RekamMedis::whereHas('reservasi', function($query) use ($reservasi) {
            $query->where('pasien_id', $reservasi->pasien_id);
        })->where('reservasi_id', '!=', $reservasi->id)
          ->with(['reservasi.jadwal.user', 'dokter', 'resepObats.obat'])
          ->orderBy('created_at', 'desc')
          ->get();

        $obats = Obat::all();
        return view('dokter.rekam.create', compact('reservasi', 'obats', 'riwayat_medis'));
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

            if (! $isOwner || !in_array($reservasi->status, ['pending', 'dikonfirmasi'])) {
                abort(403);
            }

            $rekam = RekamMedis::create([
                'reservasi_id' => $reservasi->id,
                'dokter_id' => auth()->user()->id,
                'pasien_id' => $reservasi->pasien_id,
                'diagnosis' => $request->diagnosis,
                'tindakan' => $request->tindakan,
            ]);

            // Simpan resep jika ada dan hitung total biaya
            $totalBiayaObat = 0;
            if ($request->has('obat_id') && is_array($request->obat_id)) {
                foreach ($request->obat_id as $idx => $obatId) {
                    if (empty($obatId)) continue;
                    $jumlah = $request->jumlah[$idx] ?? 1;
                    $aturan = $request->aturan_pakai[$idx] ?? '';

                    $obat = Obat::findOrFail($obatId);
                    $totalBiayaObat += $jumlah * $obat->harga;

                    ResepObat::create([
                        'rekam_medis_id' => $rekam->id,
                        'obat_id' => $obatId,
                        'jumlah' => $jumlah,
                        'aturan_pakai' => $aturan,
                    ]);
                }
            }

            // Hitung total biaya: biaya penanganan + total biaya obat
            $biayaPenanganan = 50000;
            $totalBiaya = $biayaPenanganan + $totalBiayaObat;

            // Tandai reservasi selesai dan simpan total biaya
            $reservasi->update([
                'status' => 'selesai',
                'total_biaya' => $totalBiaya
            ]);

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
        
        // Pengecekan status pembayaran
        abort_if(optional($rekam->reservasi)->status_pembayaran !== 'lunas', 403, 'Anda hanya bisa melihat detail riwayat setelah pembayaran lunas.');

        return view('pasien.riwayat-detail', compact('rekam'));
    }
}
