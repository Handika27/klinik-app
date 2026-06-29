<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\RekamMedis;
use App\Models\ResepObat;
use App\Models\Obat;

class RekamMedisController extends Controller
{
    // Tampilkan daftar pasien yang statusnya dikonfirmasi untuk hari ini (dokter)
    public function index()
    {
        abort_if(auth()->user()->role !== 'dokter', 403);

        $today = date('Y-m-d');
        $jadwalIds = auth()->user()->jadwaldokters()->pluck('id')->toArray();

        $reservasis = Reservasi::with(['pasien', 'jadwal'])
            ->whereIn('jadwal_id', $jadwalIds)
            ->where('tanggal_kunjungan', $today)
            ->where('status', 'dikonfirmasi')
            ->get();

        return view('dokter.rekam.index', compact('reservasis'));
    }

    // Form untuk membuat rekam medis untuk reservasi tertentu
    public function create($reservasiId)
    {
        abort_if(auth()->user()->role !== 'dokter', 403);

        $reservasi = Reservasi::with(['pasien', 'jadwal'])->findOrFail($reservasiId);
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
            $reservasi = Reservasi::findOrFail($request->reservasi_id);

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
}
