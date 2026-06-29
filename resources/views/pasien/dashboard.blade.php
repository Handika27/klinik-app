<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat Datang di Klinik") }}
                    <div class="mt-6 flex flex-wrap gap-4">
                        <a href="{{ route('pasien.jadwal') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded transition duration-150">Lihat Jadwal Dokter &rarr;</a>
                        <a href="{{ route('pasien.reservasi.index') }}" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded transition duration-150">Reservasi Saya &rarr;</a>
                        <a href="{{ route('pasien.riwayat') }}" class="bg-purple-600 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded transition duration-150">Riwayat Pemeriksaan &rarr;</a>
                    </div>
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
