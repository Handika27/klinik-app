<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <!-- Status Klinik -->
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-500">Status Klinik:</span>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-full {{ $clinicIsOpen ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    <span class="w-2 h-2 rounded-full {{ $clinicIsOpen ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></span>
                    <span class="text-sm font-semibold">{{ $clinicOperationalMessage }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat Datang di Klinik") }}
                    <div class="mt-6 flex flex-wrap gap-4">
                        <a href="{{ route('pasien.jadwal') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded transition duration-150">Lihat Jadwal Dokter &rarr;</a>
                        <a href="{{ route('pasien.reservasi.index') }}" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded transition duration-150">Reservasi Saya &rarr;</a>
                        <a href="{{ route('pasien.riwayat') }}" class="bg-purple-600 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded transition duration-150">Riwayat Pemeriksaan &rarr;</a>
                    </div>
                </div>
            </div>
            
            @if($activeAnnouncements->count() > 0)
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">📢 Pengumuman Terbaru</h3>
                    @foreach($activeAnnouncements as $announcement)
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-2xl shadow-lg overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 110-6M16 13a5 5 0 110-10 5 5 0 010 10z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between gap-2">
                                            <h3 class="text-lg font-bold">{{ $announcement->judul }}</h3>
                                            <span class="text-xs bg-white/20 px-2 py-1 rounded-full">{{ $announcement->tanggal_rilis->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <p class="mt-2 text-indigo-100">{{ $announcement->konten }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Tombol WhatsApp Floating -->
    <x-whatsapp-button />

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
