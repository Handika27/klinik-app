<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Anti-cache meta tags -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>{{ config('app.name', 'Klinik Medika') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-slate-50">
    
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Desktop -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col shadow-2xl z-20 hidden md:flex">
            
            <div class="h-20 flex items-center px-6 border-b border-slate-800">
                <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center mr-3">
                    <div class="w-3 h-3 rounded-full bg-white opacity-80"></div>
               </div>
                <span class="text-xl font-bold tracking-tight">Klinik <span class="font-normal text-emerald-400">Medika</span></span>
            </div>

            <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
                <p class="px-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Menu Utama</p>
                
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('*dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                @if(auth()->user() && auth()->user()->role === 'pasien')
                    <a href="{{ route('pasien.jadwal') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('pasien.jadwal') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Jadwal Dokter</span>
                    </a>
                    <a href="{{ route('pasien.reservasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('pasien.reservasi.index') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Reservasi Saya</span>
                    </a>
                    <a href="{{ route('pasien.riwayat') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('pasien.riwayat*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="font-medium">Riwayat Pemeriksaan</span>
                    </a>
                @endif

                @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'dokter']))
                    <a href="{{ route('jadwal.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('jadwal.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Kelola Jadwal</span>
                    </a>
                @endif

                @if(auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{ route('obat.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('obat.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="font-medium">Obat</span>
                    </a>
                    <a href="{{ route('admin.reservasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.reservasi.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Reservasi</span>
                    </a>
                @endif

                @if(auth()->user() && auth()->user()->role === 'dokter')
                    <a href="{{ route('dokter.reservasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dokter.reservasi.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Kelola Reservasi</span>
                    </a>
                    @php
                        // Hitung jumlah antrean untuk sidebar
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
                        $sidebarBadgeColor = $antreanCount === 0 ? 'bg-emerald-500' : ($antreanCount <= 3 ? 'bg-yellow-500' : 'bg-red-500');
                    @endphp
                    <a href="{{ route('dokter.rekam.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dokter.rekam.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="font-medium flex-1">Rekam Medis</span>
                        @if($antreanCount > 0)
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full {{ $sidebarBadgeColor }} text-white text-xs font-bold animate-pulse">
                                {{ $antreanCount }}
                            </span>
                        @endif
                    </a>
                @endif
            </nav>

            <div class="p-4 border-t border-slate-800 bg-slate-950">
                <div class="flex items-center gap-3 px-2 mb-4">
                    <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-emerald-400 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-slate-300 bg-slate-800 hover:bg-red-500 hover:text-white rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Sidebar Mobile -->
        <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden" onclick="toggleMobileSidebar()"></div>
        <aside id="mobile-sidebar" class="fixed left-0 top-0 h-full w-64 bg-slate-900 text-white flex flex-col shadow-2xl z-40 -translate-x-full transition-transform duration-300 md:hidden">
            
            <div class="h-20 flex items-center px-6 border-b border-slate-800">
                <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center mr-3">
                    <div class="w-3 h-3 rounded-full bg-white opacity-80"></div>
               </div>
                <span class="text-xl font-bold tracking-tight">Klinik <span class="font-normal text-emerald-400">Medika</span></span>
            </div>

            <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
                <p class="px-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Menu Utama</p>
                
                <a href="{{ route('dashboard') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('*dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                @if(auth()->user() && auth()->user()->role === 'pasien')
                    <a href="{{ route('pasien.jadwal') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('pasien.jadwal') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Jadwal Dokter</span>
                    </a>
                    <a href="{{ route('pasien.reservasi.index') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('pasien.reservasi.index') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Reservasi Saya</span>
                    </a>
                    <a href="{{ route('pasien.riwayat') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('pasien.riwayat*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="font-medium">Riwayat Pemeriksaan</span>
                    </a>
                @endif

                @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'dokter']))
                    <a href="{{ route('jadwal.index') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('jadwal.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Kelola Jadwal</span>
                    </a>
                @endif

                @if(auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{ route('obat.index') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('obat.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="font-medium">Obat</span>
                    </a>
                    <a href="{{ route('admin.reservasi.index') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.reservasi.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Reservasi</span>
                    </a>
                @endif

                @if(auth()->user() && auth()->user()->role === 'dokter')
                    <a href="{{ route('dokter.reservasi.index') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dokter.reservasi.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Kelola Reservasi</span>
                    </a>
                    @php
                        // Gunakan variabel antreanCount dan sidebarBadgeColor yang sudah dihitung di atas
                    @endphp
                    <a href="{{ route('dokter.rekam.index') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dokter.rekam.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="font-medium flex-1">Rekam Medis</span>
                        @if($antreanCount > 0)
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full {{ $sidebarBadgeColor }} text-white text-xs font-bold animate-pulse">
                                {{ $antreanCount }}
                            </span>
                        @endif
                    </a>
                @endif
            </nav>

            <div class="p-4 border-t border-slate-800 bg-slate-950">
                <div class="flex items-center gap-3 px-2 mb-4">
                    <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-emerald-400 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-slate-300 bg-slate-800 hover:bg-red-500 hover:text-white rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden relative">
            
            <!-- Header dengan Menu Hamburger -->
            <header class="bg-white shadow-sm border-b border-slate-200 z-10">
                <div class="py-5 px-6 sm:px-8 flex justify-between items-center">
                    <button onclick="toggleMobileSidebar()" class="md:hidden p-2 rounded-lg hover:bg-slate-100">
                        <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <div class="flex items-center gap-2">
                        @if (isset($header))
                            {{ $header }}
                        @endif
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-slate-500">{{ now()->format('l, d F Y') }}</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-slate-50 p-6 md:p-8">
                {{ $slot }}
            </main>

        </div>

    </div>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>
