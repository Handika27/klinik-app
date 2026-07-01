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
                    <a href="{{ route('announcements.index') }}" class="bg-purple-600 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded transition duration-150">
                        Kelola Pengumuman &rarr;
                    </a>
                </div>
                
                <!-- Form Pengaturan Status Operasional Klinik -->
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengaturan Status Operasional Klinik</h3>
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.clinic.status.update') }}" method="POST" class="bg-gray-50 p-4 rounded-lg">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status Klinik</label>
                                <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @php
                                        $c_status = Cache::get('clinic_status', 'buka');
                                        $s1_open = Cache::get('shift1_open', '08:00');
                                        $s1_close = Cache::get('shift1_close', '12:00');
                                        $s2_open = Cache::get('shift2_open', '14:00');
                                        $s2_close = Cache::get('shift2_close', '20:00');
                                    @endphp
                                    <option value="buka" {{ $c_status == 'buka' ? 'selected' : '' }}>Buka</option>
                                    <option value="tutup" {{ $c_status == 'tutup' ? 'selected' : '' }}>Tutup</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Shift 1 (Pagi) -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                                    Shift 1 (Pagi)
                                </h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Jam Buka</label>
                                        <input type="time" name="shift1_open" value="{{ $s1_open }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Jam Tutup</label>
                                        <input type="time" name="shift1_close" value="{{ $s1_close }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>
                            </div>
                            <!-- Shift 2 (Sore/Malam) -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                    Shift 2 (Sore/Malam)
                                </h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Jam Buka</label>
                                        <input type="time" name="shift2_open" value="{{ $s2_open }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Jam Tutup</label>
                                        <input type="time" name="shift2_close" value="{{ $s2_close }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-150">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
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
