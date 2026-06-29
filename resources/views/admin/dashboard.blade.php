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
                    {{ __("Selamat Datang di Panel Admin Klinik") }}
                    <div class="mt-6">
                        <a href="{{ route('jadwal.index') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded transition duration-150">
                            Kelola Jadwal Dokter &rarr;
                        </a>
                        <a href="{{ route('obat.index') }}" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded transition duration-150 ml-4">
                            Kelola Data Obat &rarr;
                        </a>
                        <a href="{{ route('admin.reservasi.index') }}" class="bg-yellow-600 hover:bg-yellow-800 text-white font-bold py-2 px-4 rounded transition duration-150 ml-4">
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
            function setupDashboardProtection() {
                // Push a dummy history entry to prevent immediate back navigation
                history.pushState(null, null, location.href);
            }

            // Setup on initial load
            setupDashboardProtection();

            // Also setup when coming back to this page from history
            window.addEventListener('pageshow', function(event) {
                setupDashboardProtection();
            });

            window.addEventListener('popstate', function(event) {
                // Show confirmation before allowing back
                if (confirm('Yakin ingin keluar dari aplikasi?')) {
                    // Redirect to home page which will log out
                    window.location.replace('/');
                } else {
                    // Push another state to stay on current page
                    history.pushState(null, null, location.href);
                }
            });
        })();
    </script>
</x-app-layout>
