<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        $announcements = Announcement::orderBy('tanggal_rilis', 'desc')->get();
        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'is_active' => 'nullable|boolean',
            'tanggal_rilis' => 'nullable|date',
        ]);

        try {
            Announcement::create([
                'judul' => $request->judul,
                'konten' => $request->konten,
                'is_active' => $request->has('is_active'),
                'tanggal_rilis' => $request->tanggal_rilis ?? now(),
            ]);

            return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        $announcement = Announcement::findOrFail($id);
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'is_active' => 'nullable|boolean',
            'tanggal_rilis' => 'nullable|date',
        ]);

        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->update([
                'judul' => $request->judul,
                'konten' => $request->konten,
                'is_active' => $request->has('is_active'),
                'tanggal_rilis' => $request->tanggal_rilis ?? now(),
            ]);

            return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->delete();

            return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
