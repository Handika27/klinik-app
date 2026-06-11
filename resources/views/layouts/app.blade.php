<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Klinik Medika') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-slate-50">
    
    <div class="flex h-screen overflow-hidden">

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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('jadwal.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('jadwal.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="font-medium">Jadwal Dokter</span>
                </a>
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
            
            @if (isset($header))
                <header class="bg-white shadow-sm border-b border-slate-200 z-10">
                    <div class="py-5 px-6 sm:px-8 flex justify-between items-center">
                        {{ $header }}
                        
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-slate-500">{{ now()->format('l, d F Y') }}</span>
                        </div>
                    </div>
                </header>
            @endif

            <main class="flex-1 overflow-y-auto bg-slate-50 p-6 md:p-8">
                {{ $slot }}
            </main>

        </div>

    </div>
</body>
</html>