<x-app-layout>
    <x-slot name="header">
        <!-- Logo App + Badge Antrean -->
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center">
                     <div class="w-2.5 h-2.5 rounded-full bg-white opacity-80"></div>
                </div>
                <span class="text-lg font-bold tracking-tight">Klinik <span class="font-normal text-emerald-600">Medika</span></span>
            </div>
            
            @php
                $count = $reservasis->count();
                $badgeColor = $count === 0 ? 'bg-emerald-500' : ($count <= 3 ? 'bg-yellow-500' : 'bg-red-500');
                $badgeLight = $count === 0 ? 'bg-emerald-100 text-emerald-800' : ($count <= 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800');
                $ringColor = $count === 0 ? 'ring-emerald-400' : ($count <= 3 ? 'ring-yellow-400' : 'ring-red-400');
            @endphp
            @if($count > 0)
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full {{ $badgeColor }} text-white text-xs font-bold animate-pulse">
                    {{ $count }}
                </span>
            @endif
        </div>
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

            <!-- Quick Access Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg {{ $count > 0 ? "ring-2 {$ringColor} ring-offset-2" : '' }}">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-2">Antrean Pasien</h3>
                                <p class="text-sm text-slate-600">Daftar pasien yang perlu Anda periksa hari ini.</p>
                            </div>
                            <span class="{{ $badgeLight }} text-xs font-bold px-2.5 py-0.5 rounded-full">
                                {{ $count }} {{ $count === 1 ? 'pasien' : 'pasien' }}
                            </span>
                        </div>
                        <a href="{{ route('dokter.reservasi.index') }}" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                            Lihat Antrean &rarr;
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-slate-900 mb-2">Arsip Rekam Medis</h3>
                        <p class="text-sm text-slate-600 mb-4">Lihat seluruh riwayat rekam medis pasien yang sudah selesai diperiksa.</p>
                        <a href="{{ route('dokter.rekam.index') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                            Lihat Arsip &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Today's Patient Queue -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 border-b pb-2 flex items-center gap-2">
                        Antrean Pasien Hari Ini
                        @if($count > 0)
                            <span class="{{ $badgeColor }} text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">
                                {{ $count }}
                            </span>
                        @endif
                    </h3>
                    @if($reservasis->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="p-3 font-semibold text-gray-700 text-sm">No</th>
                                        <th class="p-3 font-semibold text-gray-700 text-sm">Pasien</th>
                                        <th class="p-3 font-semibold text-gray-700 text-sm">Antrean</th>
                                        <th class="p-3 font-semibold text-gray-700 text-sm">Status</th>
                                        <th class="p-3 font-semibold text-gray-700 text-sm">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservasis as $index => $r)
                                        <tr class="border-b hover:bg-slate-50 transition-colors">
                                            <td class="p-4">{{ $index + 1 }}</td>
                                            <td class="p-4 font-medium">{{ $r->pasien->name ?? '—' }}</td>
                                            <td class="p-4">
                                                <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm font-medium">{{ $r->nomor_antrean }}</span>
                                            </td>
                                            <td class="p-4">
                                                <span class="px-2 py-1 rounded text-sm font-medium {{ $r->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status == 'dikonfirmasi' ? 'bg-emerald-100 text-emerald-800' : ($r->status == 'selesai' ? 'bg-indigo-100 text-indigo-800' : 'bg-red-100 text-red-800')) }}">
                                                    {{ $r->status == 'pending' ? 'Menunggu' : ($r->status == 'dikonfirmasi' ? 'Disetujui' : ($r->status == 'selesai' ? 'Selesai' : 'Batal')) }}
                                                </span>
                                            </td>
                                            <td class="p-4">
                                                @if($r->status === 'dikonfirmasi')
                                                    <a href="{{ route('dokter.rekam.create', $r->id) }}" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-1 px-3 rounded text-sm animate-pulse">
                                                        Isi Rekam Medis
                                                    </a>
                                                @elseif($r->status === 'pending')
                                                    <form action="{{ route('dokter.reservasi.updateStatus', $r->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        <input type="hidden" name="status" value="dikonfirmasi">
                                                        <button type="submit" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                            Konfirmasi
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-slate-400 text-sm">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-slate-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c1.657 0 3 .895 3 2s-1.343 2-3 2-3 .895-3 2 1.343 2 3 2m0-8c-1.11 0-2.08.402-2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>Belum ada antrean pasien untuk hari ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Prevent accidental back button/swipe back only on this dashboard page
        (function() {
            // Setup initial history state
            history.replaceState({ dashboard: true }, '', location.href);
            
            // Always keep one extra state so back button triggers popstate
            history.pushState(null, '', location.href);

            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    history.replaceState({ dashboard: true }, '', location.href);
                    history.pushState(null, '', location.href);
                }
            });

            window.addEventListener('popstate', function(event) {
                // Always show confirmation on back button
                showLogoutModal(function(confirmed) {
                    if (confirmed) {
                        window.location.replace('/');
                    } else {
                        // Push state again to prevent further back attempts
                        history.pushState(null, '', location.href);
                    }
                });
            });
        })();
    </script>
</x-app-layout>
