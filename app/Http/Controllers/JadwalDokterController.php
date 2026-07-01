<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalDokter;
use App\Models\User;

class JadwalDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!in_array(auth()->user()->role, ['admin', 'dokter'])) {
            abort(403);
        }
        
        // Mengambil semua data dari tabel jadwal_dokters
        $jadwals = JadwalDokter::all();
        
        // Mengirim variabel $jadwals ke halaman view
        return view('jadwal.index', compact('jadwals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!in_array(auth()->user()->role, ['admin', 'dokter'])) {
            abort(403);
        }
        
        // Ambil daftar user dengan role dokter
        $doctors = User::where('role', 'dokter')->get();
        return view('jadwal.create', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'dokter_id' => 'required|exists:users,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        try {
            // Proses Simpan Data
            $doctor = User::findOrFail($request->dokter_id);
            JadwalDokter::create([
                'user_id' => $doctor->id,
                'nama_dokter' => $doctor->name,
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
            ]);

            // Jika sukses, kembalikan ke halaman tabel BERSAMA pesan sukses
            return redirect()->route('jadwal.index')->with('success', 'Jadwal dokter berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Jika gagal, kembalikan ke halaman sebelumnya BERSAMA pesan error
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Cari data berdasarkan ID
        $jadwal = JadwalDokter::findOrFail($id);
        // Ambil daftar dokter untuk select
        $doctors = User::where('role', 'dokter')->get();
        // Buka halaman form edit sambil membawa data lama
        return view('jadwal.edit', compact('jadwal', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validasi inputan baru
        $request->validate([
            'dokter_id' => 'required|exists:users,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        try {
            // 2. Cari data lama yang mau diubah
            $jadwal = JadwalDokter::findOrFail($id);
            
            // 3. Timpa dengan data baru
            $doctor = User::findOrFail($request->dokter_id);
            $jadwal->update([
                'user_id' => $doctor->id,
                'nama_dokter' => $doctor->name,
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
            ]);

            // 4. Kembalikan ke tabel dengan pesan sukses
            return redirect()->route('jadwal.index')->with('success', 'Jadwal dokter berhasil diperbarui!');

        } catch (\Exception $e) {
            // Jika error, kembalikan dengan pesan gagal
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function destroy($id)
    {
        try {
            // Cari data berdasarkan ID
            $jadwal = JadwalDokter::findOrFail($id);
            
            // Hapus data
            $jadwal->delete();

            // Kembalikan ke tabel dengan pesan sukses
            return redirect()->route('jadwal.index')->with('success', 'Data jadwal berhasil dihapus!');

        } catch (\Exception $e) {
            // Jika gagal, tampilkan pesan error
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }


    
    // Toggle status jadwal antara aktif dan cuti
    public function toggleStatus($id)
    {
        if (!in_array(auth()->user()->role, ['admin'])) {
            abort(403);
        }
        
        try {
            $jadwal = JadwalDokter::findOrFail($id);
            $jadwal->status = $jadwal->status === 'aktif' ? 'cuti' : 'aktif';
            $jadwal->save();
            
            return redirect()->route('jadwal.index')->with('success', "Status jadwal berhasil diubah menjadi {$jadwal->status}!");
        } catch (\Exception $e) {
            return redirect()->route('jadwal.index')->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }
}
