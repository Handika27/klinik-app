<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
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
                    <h3 class="text-lg font-semibold text-gray-800 mb-4"> Pengumuman Terbaru</h3>
                    @foreach($activeAnnouncements as $announcement)
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-2xl shadow-lg overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
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
