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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                @if(auth()->user() && auth()->user()->role === 'pasien')
                    <a href="{{ route('pasien.jadwal') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('pasien.jadwal') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Jadwal Dokter</span>
                    </a>
                    <a href="{{ route('pasien.reservasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('pasien.reservasi.index') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14v4m0 0v4m0-4h4m-4 0h-4"></path></svg>
                        <span class="font-medium">Reservasi Saya</span>
                    </a>
                    <a href="{{ route('pasien.riwayat') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('pasien.riwayat*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        <span class="font-medium">Obat</span>
                    </a>
                    <a href="{{ route('admin.reservasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.reservasi.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="font-medium">Reservasi</span>
                    </a>
                    <a href="{{ route('announcements.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('announcements.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <!-- Megaphone (Toa) - bigger and clearer -->
                            <path d="M3 11l18-5v10l-18-5z"></path>
                            <path d="M11 19l-4-1"></path>
                            <path d="M11 3l-4-1"></path>
                            <!-- Gear (Roda Gerigi) - in bottom right, more prominent -->
                            <circle cx="20" cy="20" r="3" stroke-width="2"></circle>
                            <path d="M20 16v1M20 23v-1M16 20h1M23 20h-1M17 17l1 1M22 22l-1-1M17 22l1-1M22 17l-1 1" stroke-width="2"></path>
                        </svg>
                        <span class="font-medium">Kelola Pengumuman</span>
                    </a>
                @endif

                @if(auth()->user() && auth()->user()->role === 'dokter')
                    <a href="{{ route('dokter.reservasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dokter.reservasi.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
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
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
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

                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
                <button class="logout-button w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-slate-300 bg-slate-800 hover:bg-red-500 hover:text-white rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Log Out
                </button>
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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                @if(auth()->user() && auth()->user()->role === 'pasien')
                    <a href="{{ route('pasien.jadwal') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('pasien.jadwal') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Jadwal Dokter</span>
                    </a>
                    <a href="{{ route('pasien.reservasi.index') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('pasien.reservasi.index') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14v4m0 0v4m0-4h4m-4 0h-4"></path></svg>
                        <span class="font-medium">Reservasi Saya</span>
                    </a>
                    <a href="{{ route('pasien.riwayat') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('pasien.riwayat*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        <span class="font-medium">Obat</span>
                    </a>
                    <a href="{{ route('admin.reservasi.index') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.reservasi.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="font-medium">Reservasi</span>
                    </a>
                    <a href="{{ route('announcements.index') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('announcements.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <!-- Megaphone (Toa) - bigger and clearer -->
                            <path d="M3 11l18-5v10l-18-5z"></path>
                            <path d="M11 19l-4-1"></path>
                            <path d="M11 3l-4-1"></path>
                            <!-- Gear (Roda Gerigi) - in bottom right, more prominent -->
                            <circle cx="20" cy="20" r="3" stroke-width="2"></circle>
                            <path d="M20 16v1M20 23v-1M16 20h1M23 20h-1M17 17l1 1M22 22l-1-1M17 22l1-1M22 17l-1 1" stroke-width="2"></path>
                        </svg>
                        <span class="font-medium">Kelola Pengumuman</span>
                    </a>
                @endif

                @if(auth()->user() && auth()->user()->role === 'dokter')
                    <a href="{{ route('dokter.reservasi.index') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dokter.reservasi.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="font-medium">Kelola Reservasi</span>
                    </a>
                    @php
                        // Gunakan variabel antreanCount dan sidebarBadgeColor yang sudah dihitung di atas
                    @endphp
                    <a href="{{ route('dokter.rekam.index') }}" onclick="toggleMobileSidebar()" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dokter.rekam.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
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

                <button class="logout-button w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-slate-300 bg-slate-800 hover:bg-red-500 hover:text-white rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Log Out
                </button>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden relative">
            
            <!-- Header dengan Menu Hamburger -->
            <header class="bg-white shadow-sm border-b border-slate-200 z-10">
                <div class="py-5 px-6 sm:px-8 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3 flex-1">
                        <button onclick="toggleMobileSidebar()" class="md:hidden p-2 rounded-lg hover:bg-slate-100">
                            <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <div class="flex-1">
                            @if (isset($header))
                                {{ $header }}
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 justify-start sm:justify-end">
                        <span class="text-sm text-slate-500">{{ now()->format('l, d F Y') }}</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-slate-50 p-6 md:p-8">
                {{ $slot }}
            </main>

        </div>

    </div>

    <!-- Modal Konfirmasi Keluar -->
    <div id="logoutModal" class="fixed inset-0 z-50 hidden">
        <!-- Overlay -->
        <div id="logoutModalOverlay" class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
        
        <!-- Modal Container -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <!-- Modal Content -->
            <div id="logoutModalContent" class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all scale-95 opacity-0">
                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Konfirmasi Keluar</h3>
                        </div>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="p-6">
                    <p class="text-slate-600 text-center">Yakin ingin keluar dari aplikasi?</p>
                </div>
                
                <!-- Footer -->
                <div class="bg-slate-50 px-6 py-4 flex gap-3">
                    <button id="logoutModalCancel" class="flex-1 px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition-colors">
                        Batal
                    </button>
                    <button id="logoutModalConfirm" class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors">
                        Keluar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Modal Konfirmasi Keluar
        let logoutCallback = null;

        function showLogoutModal(callback) {
            logoutCallback = callback;
            const modal = document.getElementById('logoutModal');
            const overlay = document.getElementById('logoutModalOverlay');
            const content = document.getElementById('logoutModalContent');
            
            modal.classList.remove('hidden');
            
            // Animasi masuk
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function hideLogoutModal() {
            const modal = document.getElementById('logoutModal');
            const overlay = document.getElementById('logoutModalOverlay');
            const content = document.getElementById('logoutModalContent');
            
            // Animasi keluar
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                logoutCallback = null;
            }, 200);
        }

        // Event listeners untuk modal
        document.getElementById('logoutModalCancel').addEventListener('click', function() {
            hideLogoutModal();
            if (logoutCallback) {
                logoutCallback(false);
            }
        });

        document.getElementById('logoutModalConfirm').addEventListener('click', function() {
            hideLogoutModal();
            if (logoutCallback) {
                logoutCallback(true);
            }
        });

        document.getElementById('logoutModalOverlay').addEventListener('click', function() {
            hideLogoutModal();
            if (logoutCallback) {
                logoutCallback(false);
            }
        });

        // Event listener untuk semua tombol Log Out
        document.querySelectorAll('.logout-button').forEach(button => {
            button.addEventListener('click', function() {
                // Tutup mobile sidebar jika terbuka
                const mobileSidebar = document.getElementById('mobile-sidebar');
                const mobileOverlay = document.getElementById('mobile-overlay');
                if (!mobileSidebar.classList.contains('-translate-x-full')) {
                    mobileSidebar.classList.add('-translate-x-full');
                    mobileOverlay.classList.add('hidden');
                }
                
                showLogoutModal(function(confirmed) {
                    if (confirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
