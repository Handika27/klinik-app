<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klinik Medika - Sistem Manajemen Kesehatan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">

    <!-- Sticky Navbar -->
    <nav x-data="{ authOpen: false }" class="sticky top-0 z-50 w-full bg-white shadow-sm">
        @php
            $c_status = Cache::get('clinic_status', 'buka');
            $s1_open = Cache::get('shift1_open', '08:00');
            $s1_close = Cache::get('shift1_close', '12:00');
            $s2_open = Cache::get('shift2_open', '14:00');
            $s2_close = Cache::get('shift2_close', '20:00');
        @endphp

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">

            <!-- Mobile Layout -->
            <div class="md:hidden py-3">
                <!-- Row 1: Logo + Tombol Masuk -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center flex-shrink-0">
                            <div class="w-3 h-3 rounded-full bg-white opacity-80"></div>
                        </div>
                        <span class="text-lg font-bold tracking-tight leading-tight">Klinik <span class="font-normal text-emerald-600">Medika</span></span>
                    </div>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-white bg-indigo-600 px-4 py-2 rounded-md">
                                Dashboard
                            </a>
                        @else
                            <button @click="authOpen = !authOpen"
                                class="text-sm font-medium text-white bg-indigo-600 px-4 py-2 rounded-md focus:outline-none">
                                Masuk
                            </button>
                        @endauth
                    @endif
                </div>

                <!-- Row 2: Status Klinik -->
                <div class="flex items-center justify-center gap-2 mt-2.5 pt-2.5 border-t border-slate-100">
                    <span class="text-xs text-slate-400 font-medium">Status Klinik:</span>
                    @if($c_status == 'buka')
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-green-700">
                            <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                            Buka {{ $s1_open }}-{{ $s1_close }} & {{ $s2_open }}-{{ $s2_close }} WIB
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-red-600">
                            <span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span>
                            Tutup – Buka pukul {{ $s1_open }} WIB
                        </span>
                    @endif
                </div>
            </div>

            <!-- Desktop Layout: 1 Row (3 Columns) -->
            <div class="hidden md:flex items-center justify-between py-3">
                <!-- Left: Logo -->
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center">
                        <div class="w-3 h-3 rounded-full bg-white opacity-80"></div>
                    </div>
                    <span class="text-xl font-bold tracking-tight">Klinik <span class="font-normal text-emerald-600">Medika</span></span>
                </div>

                <!-- Center: Status Klinik -->
                <div class="flex items-center gap-2">
                    <span class="text-sm text-slate-400">Status Klinik:</span>
                    @if($c_status == 'buka')
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-green-700 whitespace-nowrap">
                            <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                            Buka ({{ $s1_open }}-{{ $s1_close }} & {{ $s2_open }}-{{ $s2_close }} WIB)
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-red-600 whitespace-nowrap">
                            <span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span>
                            Tutup – Buka kembali pukul {{ $s1_open }} WIB
                        </span>
                    @endif
                </div>

                <!-- Right: Auth Buttons -->
                @if (Route::has('login'))
                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">
                                Kembali ke Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow transition">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow transition">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>

        </div>

        <!-- Mobile Auth Panel: full-width, muncul di bawah navbar saat tombol Masuk diklik -->
        @if (Route::has('login'))
            @guest
                <div x-show="authOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="md:hidden border-t border-gray-200 bg-white"
                    style="display: none;">
                    <a href="{{ route('login') }}" class="block w-full text-center py-3 text-sm font-medium text-indigo-600 border-b border-gray-100 hover:bg-gray-50">
                        Log In
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block w-full text-center py-3 text-sm font-medium text-indigo-600 hover:bg-gray-50">
                            Register
                        </a>
                    @endif
                </div>
            @endguest
        @endif

    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 md:px-12 pt-8 pb-16 md:pt-16 md:pb-24">

        <!-- Hero Section -->
        <div class="flex flex-col-reverse md:flex-row items-center gap-12 py-8 mb-12">
            
            <div class="w-full md:w-1/2 flex flex-col items-center md:items-start text-center md:text-left">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight text-slate-900 mb-6">
                    Selamat Datang di Layanan Terpadu Klinik Medika! <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-emerald-500">
                       
                    </span>
                </h1>
                <p class="text-lg text-slate-600 mb-8 max-w-lg">
                    Lihat jadwal operasional kami, pengumuman, dan update lainnya. Daftar mudah dengan reservasi online.
                </p>
                
                <div class="flex gap-4">
                    <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition duration-200">
                        Mulai Sekarang
                    </a>
                    <a href="#jadwal-operasional" class="bg-white hover:bg-slate-100 text-slate-700 font-bold py-3 px-8 rounded-xl shadow border border-slate-200 transition duration-200">
                        Lihat Jadwal
                    </a>
                </div>
            </div>

            <div class="w-full md:w-1/2 flex justify-center">
                <div class="relative w-full max-w-md flex items-center justify-center p-4">
                    <div class="absolute top-10 right-10 w-32 h-32 bg-emerald-400 rounded-full opacity-30 blur-3xl z-0"></div>
                    <div class="absolute bottom-10 left-10 w-40 h-40 bg-indigo-600 rounded-full opacity-20 blur-3xl z-0"></div>
                    
                    <img src="{{ asset('images/Medicine-pana.svg') }}" 
                         alt="Ilustrasi Layanan Klinik Medika" 
                         class="relative z-10 w-full h-auto object-contain drop-shadow-xl hover:scale-105 transition-transform duration-500">
                </div>
            </div>

        </div>

        <!-- Pengumuman -->
        @if($activeAnnouncements->count() > 0)
            <div class="space-y-4 mb-16">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Pengumuman Terbaru</h2>
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

        <!-- Jadwal Operasional Dokter -->
        <div id="jadwal-operasional" class="mb-16 pt-20">
            <p class="text-lg text-slate-600 mb-8 max-w-lg">
            
            </p>
            
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Jadwal Operasional Dokter</h2>
            <div class="overflow-x-auto bg-white rounded-lg shadow mb-8">
                @php
                    $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    $grouped_jadwal = $jadwals->groupBy('hari');
                @endphp

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-indigo-600 text-white">
                            <th class="py-3 px-4 font-semibold text-sm border-b border-indigo-700">Hari & Waktu</th>
                            <th class="py-3 px-4 font-semibold text-sm border-b border-indigo-700">Nama Dokter</th>
                            <th class="py-3 px-4 font-semibold text-sm border-b border-indigo-700">Jam Praktik</th>
                            <th class="py-3 px-4 font-semibold text-sm border-b border-indigo-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($hari_list as $hari)
                            @if(isset($grouped_jadwal[$hari]) && $grouped_jadwal[$hari]->count() > 0)
                                @php
                                    $jadwal_hari_ini = $grouped_jadwal[$hari];
                                    // Shift 1 (Pagi/Siang): Mulai sebelum jam 13:00
                                    $shift_pagi = $jadwal_hari_ini->filter(fn($j) => $j->jam_mulai < '13:00:00')->values();
                                    // Shift 2 (Sore/Malam): Mulai dari jam 13:00 ke atas
                                    $shift_sore = $jadwal_hari_ini->filter(fn($j) => $j->jam_mulai >= '13:00:00')->values();
                                @endphp

                                @if($shift_pagi->count() > 0)
                                    @foreach($shift_pagi as $index => $jadwal)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            @if($index == 0)
                                                <td class="py-3 px-4 font-medium text-gray-900 align-top bg-indigo-50/50 border-r border-gray-200" rowspan="{{ $shift_pagi->count() }}">
                                                    <div class="text-base text-indigo-700 font-bold uppercase tracking-wide">{{ $hari }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">Shift Pagi</div>
                                                </td>
                                            @endif
                                            <td class="py-3 px-4">
                                                <div class="font-medium text-gray-800">{{ $jadwal->user->name ?? ($jadwal->nama_dokter ?? 'Dokter') }}</div>
                                                @if($jadwal->status === 'cuti')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 whitespace-nowrap mt-1">
                                                        Cuti
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 whitespace-nowrap mt-1">
                                                        Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-600 font-medium">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                @if($jadwal->status == 'aktif')
                                                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md shadow-sm transition-colors" title="Login untuk Booking">
                                                        Booking
                                                    </a>
                                                @else
                                                    <button disabled class="inline-flex items-center px-4 py-1.5 bg-red-100 text-red-700 text-sm font-semibold rounded-md cursor-not-allowed">Cuti / Penuh</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                                @if($shift_sore->count() > 0)
                                    @foreach($shift_sore as $index => $jadwal)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            @if($index == 0)
                                                <td class="py-3 px-4 font-medium text-gray-900 align-top bg-emerald-50/50 border-r border-gray-200" rowspan="{{ $shift_sore->count() }}">
                                                    <div class="text-base text-emerald-700 font-bold uppercase tracking-wide">{{ $hari }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">Shift Sore</div>
                                                </td>
                                            @endif
                                            <td class="py-3 px-4">
                                                <div class="font-medium text-gray-800">{{ $jadwal->user->name ?? ($jadwal->nama_dokter ?? 'Dokter') }}</div>
                                                @if($jadwal->status === 'cuti')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 whitespace-nowrap mt-1">
                                                        Cuti
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 whitespace-nowrap mt-1">
                                                        Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-600 font-medium">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                @if($jadwal->status == 'aktif')
                                                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-md shadow-sm transition-colors" title="Login untuk Booking">
                                                        Booking
                                                    </a>
                                                @else
                                                    <button disabled class="inline-flex items-center px-4 py-1.5 bg-red-100 text-red-700 text-sm font-semibold rounded-md cursor-not-allowed">Cuti / Penuh</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Tombol WhatsApp Floating -->
    <x-whatsapp-button />

</body>
</html>