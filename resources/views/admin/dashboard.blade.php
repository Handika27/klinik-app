<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 w-full">
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
