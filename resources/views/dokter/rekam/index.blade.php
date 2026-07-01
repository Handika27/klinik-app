<x-app-layout>
    <x-slot name="header">
        @php
            $dokterId = auth()->user()->id;
            $dokterName = auth()->user()->name;
            $today = now()->format('Y-m-d');
            $jadwalIds = \App\Models\JadwalDokter::where(function($q) use ($dokterId, $dokterName) {
                $q->where('user_id', $dokterId)->orWhere('nama_dokter', $dokterName);
            })->pluck('id')->toArray();
            $antreanCount = \App\Models\Reservasi::whereIn('jadwal_id', $jadwalIds)
                ->where('status', 'dikonfirmasi')
                ->where('tanggal_kunjungan', $today)
                ->count();
            $badgeColor = $antreanCount === 0 ? 'bg-emerald-500' : ($antreanCount <= 3 ? 'bg-yellow-500' : 'bg-red-500');
        @endphp
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-3">
            {{ __('Antrean & Rekam Medis') }}
            @if($antreanCount > 0)
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $badgeColor }} text-white text-xs font-bold animate-pulse">
                    {{ $antreanCount }}
                </span>
            @endif
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
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        Daftar Antrean
                        @if($antreanCount > 0)
                            <span class="{{ $badgeColor }} text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">
                                {{ $antreanCount }}
                            </span>
                        @endif
                    </h3>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="p-3 font-semibold text-gray-700 text-sm">No</th>
                                <th class="p-3 font-semibold text-gray-700 text-sm">Pasien</th>
                                <th class="p-3 font-semibold text-gray-700 text-sm">Tanggal</th>
                                <th class="p-3 font-semibold text-gray-700 text-sm">Antrean</th>
                                <th class="p-3 font-semibold text-gray-700 text-sm">Status</th>
                                <th class="p-3 font-semibold text-gray-700 text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservasis as $index => $r)
                                <tr class="border-b hover:bg-slate-50 transition-colors">
                                    <td class="p-4">{{ $index + 1 }}</td>
                                    <td class="p-4 font-medium">{{ $r->pasien->name ?? '—' }}</td>
                                    <td class="p-4">{{ $r->tanggal_kunjungan }}</td>
                                    <td class="p-4">
                                        <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm font-medium">{{ $r->nomor_antrean }}</span>
                                    </td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 rounded text-sm font-medium {{ $r->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status == 'dikonfirmasi' ? 'bg-emerald-100 text-emerald-800' : ($r->status == 'selesai' ? 'bg-indigo-100 text-indigo-800' : 'bg-red-100 text-red-800')) }}">{{ $r->status == 'pending' ? 'Menunggu' : ($r->status == 'dikonfirmasi' ? 'Disetujui' : ($r->status == 'selesai' ? 'Selesai' : 'Batal')) }}</span>
                                    </td>
                                    <td class="p-4">
                                        <div class="space-y-2">
                                            @if($r->status === 'pending' || $r->status === 'dikonfirmasi')
                                                <a href="{{ route('dokter.rekam.create', $r->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                                                    Proses
                                                </a>
                                            @elseif($r->status === 'selesai')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 whitespace-nowrap">
                                                    Selesai Diperiksa
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-6 text-center text-slate-500" colspan="6">Belum ada reservasi untuk jadwal Anda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
