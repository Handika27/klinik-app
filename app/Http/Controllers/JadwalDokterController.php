<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalDokter;

class JadwalDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Nantinya kita akan mengambil data dari database di sini
        // Untuk sekarang, kita arahkan dulu ke halaman antarmukanya
        
        return view('jadwal.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jadwal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi inputan (pastikan tidak ada yang kosong)
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        // 2. Simpan data ke tabel jadwal_dokters
        JadwalDokter::create([
            'user_id' => auth()->user()->id, // Otomatis mengisi ID dokter yang sedang login
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        // 3. Kembalikan ke halaman tabel (index)
        return redirect()->route('jadwal.index');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
