<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arsip Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded shadow-sm">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded shadow-sm">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Arsip Rekam Medis</h3>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="p-3 font-semibold text-gray-700 text-sm">Tanggal</th>
                                <th class="p-3 font-semibold text-gray-700 text-sm">Nama Pasien</th>
                                <th class="p-3 font-semibold text-gray-700 text-sm">Keluhan</th>
                                <th class="p-3 font-semibold text-gray-700 text-sm">Diagnosa</th>
                                <th class="p-3 font-semibold text-gray-700 text-sm">Resep Obat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($arsip_medis as $rm)
                                <tr class="border-b hover:bg-slate-50 transition-colors">
                                    <td class="p-4">{{ $rm->created_at->format('d M Y') }}</td>
                                    <td class="p-4 font-medium">{{ $rm->reservasi->pasien->name ?? 'Pasien Umum' }}</td>
                                    <td class="p-4">{{ $rm->reservasi->keluhan_awal ?? '—' }}</td>
                                    <td class="p-4">{{ Str::limit($rm->diagnosis, 100) }}</td>
                                    <td class="p-4">
                                        @if($rm->resepObats->count() > 0)
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach($rm->resepObats as $ro)
                                                    <li class="text-sm">{{ $ro->obat->nama_obat ?? 'Obat tidak ditemukan' }} ({{ $ro->jumlah }}x) — {{ $ro->aturan_pakai ?? '-' }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-gray-400 text-sm">Tidak ada resep</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-6 text-center text-slate-500" colspan="5">Belum ada data arsip rekam medis.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
