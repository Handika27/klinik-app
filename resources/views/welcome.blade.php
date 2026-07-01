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
    <nav class="sticky top-0 z-50 w-full bg-white shadow-sm py-3 px-6 md:px-12">
        @php
            $c_status = Cache::get('clinic_status', 'buka');
            $s1_open = Cache::get('shift1_open', '08:00');
            $s1_close = Cache::get('shift1_close', '12:00');
            $s2_open = Cache::get('shift2_open', '14:00');
            $s2_close = Cache::get('shift2_close', '20:00');
        @endphp
        <!-- Mobile Layout: 2 Rows -->
        <div class="md:hidden">
            <!-- Top Row: Logo + Auth Buttons -->
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center">
                         <div class="w-3 h-3 rounded-full bg-white opacity-80"></div>
                    </div>
                    <span class="text-xl font-bold tracking-tight">Klinik <span class="font-normal text-emerald-600">Medika</span></span>
                </div>

                @if (Route::has('login'))
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">
                                Kembali ke Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">
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

            <!-- Bottom Row: Status Klinik (Center) -->
            <div class="flex items-center justify-center gap-2">
                <span class="text-sm text-slate-500">Status Klinik:</span>
                @if($c_status == 'buka')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 whitespace-nowrap">
                        <svg class="w-4 h-4 mr-1.5 text-green-500 fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                        Buka ({{ $s1_open }}-{{ $s1_close }} & {{ $s2_open }}-{{ $s2_close }} WIB)
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 whitespace-nowrap">
                        <svg class="w-4 h-4 mr-1.5 text-red-500 fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                        Tutup - Buka kembali pukul {{ $s1_open }} WIB
                    </span>
                @endif
            </div>
        </div>

        <!-- Desktop Layout: 1 Row (3 Columns) -->
        <div class="hidden md:flex items-center justify-between">
            <!-- Left: Logo -->
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center">
                     <div class="w-3 h-3 rounded-full bg-white opacity-80"></div>
                </div>
                <span class="text-xl font-bold tracking-tight">Klinik <span class="font-normal text-emerald-600">Medika</span></span>
            </div>

            <!-- Center: Status Klinik -->
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-500">Status Klinik:</span>
                @if($c_status == 'buka')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 whitespace-nowrap">
                        <svg class="w-4 h-4 mr-1.5 text-green-500 fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                        Buka ({{ $s1_open }}-{{ $s1_close }} & {{ $s2_open }}-{{ $s2_close }} WIB)
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 whitespace-nowrap">
                        <svg class="w-4 h-4 mr-1.5 text-red-500 fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                        Tutup - Buka kembali pukul {{ $s1_open }} WIB
                    </span>
                @endif
            </div>

            <!-- Right: Auth Buttons -->
            @if (Route::has('login'))
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">
                            Kembali ke Dashboard &rarr;
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">
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
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 md:px-12 pt-8 pb-16 md:pt-16 md:pb-24">

        <!-- Hero Section -->
        <div class="flex flex-col-reverse md:flex-row items-center gap-12 py-8 mb-12">
            
            <div class="w-full md:w-1/2 flex flex-col items-center md:items-start text-center md:text-left">
                <div class="inline-block bg-emerald-100 text-emerald-800 px-4 py-1.5 rounded-full text-sm font-semibold mb-6">
                    🚀 Platform Kesehatan Modern 2026
                </div>
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight text-slate-900 mb-6">
                    Kelola Klinik Anda <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-emerald-500">
                        Lebih Cerdas & Cepat.
                    </span>
                </h1>
                <p class="text-lg text-slate-600 mb-8 max-w-lg">
                    Sistem informasi terpadu untuk mengatur jadwal dokter, rekam medis pasien, dan operasional fasilitas kesehatan Anda dalam satu pintu.
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
                <div class="relative w-full max-w-md aspect-square bg-indigo-50 rounded-3xl border-2 border-dashed border-indigo-200 flex flex-col items-center justify-center p-8 text-center shadow-inner">
                    <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mb-4 text-3xl">
                        🏥
                    </div>
                    <h3 class="text-indigo-800 font-bold text-xl mb-2">[Area Ilustrasi Klinik]</h3>
                    <p class="text-indigo-600 text-sm">Tempatkan gambar vektor dokter atau render 3D bangunan klinik di sini.</p>
                    
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-emerald-400 rounded-full opacity-20 blur-2xl"></div>
                    <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-indigo-600 rounded-full opacity-20 blur-2xl"></div>
                </div>
            </div>

        </div>

        <!-- Pengumuman -->
        @if($activeAnnouncements->count() > 0)
            <div class="space-y-4 mb-16">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">📢 Pengumuman Terbaru</h2>
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

        <!-- Jadwal Operasional Dokter -->
        <div id="jadwal-operasional" class="mb-16 pt-20">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">🗓️ Jadwal Operasional Dokter</h2>
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