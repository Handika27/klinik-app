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

    // Ubah status reservasi (misal setujui atau tolak)
    public function updateStatus(Request $request, $id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $request->validate([
            'status' => 'required|in:pending,dikonfirmasi,selesai,batal',
        ]);

        try {
            $reservasi = Reservasi::findOrFail($id);
            $reservasi->update([
                'status' => $request->status,
            ]);

            return redirect()->route('admin.reservasi.index')->with('success', 'Status reservasi diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }
}
