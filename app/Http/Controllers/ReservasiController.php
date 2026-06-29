<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\JadwalDokter;

class ReservasiController extends Controller
{
    // Halaman untuk pasien melihat jadwal dan melakukan booking
    public function pasienJadwal()
    {
        abort_if(auth()->user()->role !== 'pasien', 403);

        $jadwals = JadwalDokter::all();
        return view('pasien.jadwal', compact('jadwals'));
    }

    // Form booking untuk pasien
    public function create($jadwalId)
    {
        abort_if(auth()->user()->role !== 'pasien', 403);

        $jadwal = JadwalDokter::findOrFail($jadwalId);
        return view('reservasi.create', compact('jadwal'));
    }

    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'pasien', 403);

        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_dokters,id',
            'tanggal_kunjungan' => 'required|date',
            'keluhan_awal' => 'nullable|string',
        ]);

        try {
            // hitung nomor antrean berdasarkan jadwal + tanggal
            $count = Reservasi::where('jadwal_id', $request->jadwal_id)
                ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
                ->count();

            $reservasi = Reservasi::create([
                'pasien_id' => auth()->user()->id,
                'jadwal_id' => $request->jadwal_id,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'nomor_antrean' => $count + 1,
                'keluhan_awal' => $request->keluhan_awal,
                'status' => 'pending',
            ]);

            return redirect()->route('pasien.jadwal')->with('success', 'Reservasi berhasil dibuat! Nomor antrean Anda: ' . $reservasi->nomor_antrean);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat reservasi: ' . $e->getMessage());
        }
    }

    // Halaman admin melihat daftar reservasi
    public function adminIndex()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $reservasis = Reservasi::with(['pasien', 'jadwal'])->orderBy('tanggal_kunjungan', 'desc')->get();
        return view('admin.reservasi.index', compact('reservasis'));
    }

    // Halaman pasien melihat daftar reservasi miliknya
    public function pasienIndex()
    {
        abort_if(auth()->user()->role !== 'pasien', 403);

        $reservasis = Reservasi::with(['jadwal'])->where('pasien_id', auth()->user()->id)->orderBy('tanggal_kunjungan', 'desc')->get();
        return view('pasien.reservasi.index', compact('reservasis'));
    }

    // Halaman untuk dokter mengelola reservasi terkait jadwal miliknya
    public function dokterIndex()
    {
        abort_if(auth()->user()->role !== 'dokter', 403);

        $dokterId = auth()->user()->id;
        $jadwalIds = \App\Models\JadwalDokter::where('user_id', $dokterId)->pluck('id')->toArray();

        $reservasis = Reservasi::with(['pasien', 'jadwal'])
            ->whereIn('jadwal_id', $jadwalIds)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();

        return view('admin.reservasi.index', compact('reservasis'));
    }

    // Ubah status reservasi (misal setujui atau tolak)
    public function updateStatus(Request $request, $id)
    {
        // Allow admin or dokter (dokter hanya untuk reservasi terkait jadwal miliknya)
        $user = auth()->user();
        if (!in_array($user->role, ['admin', 'dokter'])) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,dikonfirmasi,selesai,batal',
        ]);

        try {
            $reservasi = Reservasi::findOrFail($id);

            if ($user->role === 'dokter') {
                // pastikan reservasi terkait jadwal milik dokter
                $isOwner = false;
                if ($reservasi->jadwal) {
                    $isOwner = ($reservasi->jadwal->user_id === $user->id) || ($reservasi->jadwal->nama_dokter === $user->name);
                }
                if (! $isOwner) {
                    abort(403);
                }
            }

            $reservasi->update([
                'status' => $request->status,
            ]);

            // redirect ke halaman sesuai peran
            if ($user->role === 'admin') {
                return redirect()->route('admin.reservasi.index')->with('success', 'Status reservasi diperbarui!');
            } else {
                return redirect()->route('dokter.rekam.index')->with('success', 'Status reservasi diperbarui!');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }
}
