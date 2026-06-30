<x-app-layout>
    <x-slot name="header">
        <!-- Logo App -->
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center">
                 <div class="w-2.5 h-2.5 rounded-full bg-white opacity-80"></div>
            </div>
            <span class="text-lg font-bold tracking-tight">Klinik <span class="font-normal text-emerald-600">Medika</span></span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat Datang di Panel Admin Klinik") }}
                    <div class="mt-6 flex flex-wrap gap-4">
                        <a href="{{ route('jadwal.index') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded transition duration-150">
                            Kelola Jadwal Dokter &rarr;
                        </a>
                        <a href="{{ route('obat.index') }}" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded transition duration-150">
                            Kelola Data Obat &rarr;
                        </a>
                        <a href="{{ route('admin.reservasi.index') }}" class="bg-yellow-600 hover:bg-yellow-800 text-white font-bold py-2 px-4 rounded transition duration-150">
                            Kelola Reservasi &rarr;
                        </a>
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
