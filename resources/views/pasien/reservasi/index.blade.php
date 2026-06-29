<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Reservasi Saya') }}</h2>
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
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border-b-2 p-3 font-semibold text-gray-700">No</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Dokter</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Tanggal</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Antrean</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Status</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservasis as $i => $r)
                                <tr class="border-b hover:bg-slate-50 transition-colors">
                                    <td class="p-4">{{ $i + 1 }}</td>
                                    <td class="p-4 font-medium">{{ $r->jadwal->nama_dokter ?? '—' }}</td>
                                    <td class="p-4">{{ $r->tanggal_kunjungan }}</td>
                                    <td class="p-4">{{ $r->nomor_antrean }}</td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 rounded text-sm font-medium {{ $r->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status == 'dikonfirmasi' ? 'bg-emerald-100 text-emerald-800' : ($r->status == 'selesai' ? 'bg-indigo-100 text-indigo-800' : 'bg-red-100 text-red-800')) }}">
                                            {{ $r->status == 'pending' ? 'Menunggu' : ($r->status == 'dikonfirmasi' ? 'Disetujui' : ($r->status == 'selesai' ? 'Selesai' : 'Batal')) }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        @if($r->status == 'selesai' && $r->rekamMedis)
                                            <a href="{{ route('pasien.riwayat.show', $r->rekamMedis->id) }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                                Lihat Hasil &rarr;
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-6 text-center text-slate-500" colspan="6">Anda belum memiliki reservasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
