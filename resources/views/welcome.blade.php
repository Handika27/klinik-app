<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klinik Medika - Sistem Manajemen Kesehatan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">

    <nav class="w-full bg-white shadow-sm py-4 px-6 md:px-12 flex justify-between items-center">
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
    </nav>

    <main class="max-w-7xl mx-auto px-6 md:px-12 py-16 md:py-24 flex flex-col-reverse md:flex-row items-center gap-12">
        
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
                <a href="#fitur" class="bg-white hover:bg-slate-100 text-slate-700 font-bold py-3 px-8 rounded-xl shadow border border-slate-200 transition duration-200">
                    Pelajari Fitur
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

    </main>

</body>
</html>