<x-guest-layout>
    <div class="min-h-screen flex">
        
        <div class="hidden md:flex md:w-1/2 bg-indigo-600 p-12 text-white flex-col justify-center relative overflow-hidden">
            <div class="absolute -top-16 -left-16 w-64 h-64 bg-indigo-500 rounded-full opacity-50"></div>
            <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-indigo-700 rounded-full opacity-50"></div>

            <div class="relative z-10 flex-grow flex items-center justify-center">
                <div class="w-full max-w-md flex items-center justify-center p-4">
                    <img src="{{ asset('images/Medicine-pana.svg') }}" 
                         alt="Ilustrasi Layanan Klinik Medika" 
                         class="w-full h-auto object-contain drop-shadow-xl">
                </div>
            </div>

            <div class="relative z-10 mt-12 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">Kesehatan Anda, <br>Dikelola dengan Mudah.</h1>
                <p class="text-indigo-100 mt-4 max-w-md">Platform manajemen klinis modern untuk fasilitas kesehatan.</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 bg-white flex justify-center items-start md:items-center p-8 md:p-16 relative">
            
            <a href="/" class="absolute top-6 right-6 md:top-8 md:right-8 text-sm text-gray-500 hover:text-indigo-600 flex items-center gap-1">
                &larr; Kembali ke Home
            </a>

            <div class="w-full max-w-md mt-16 md:mt-0">
                
                <div class="mb-10 text-center md:text-left">
                    <div class="flex items-center gap-2 mb-3 justify-center md:justify-start">
                        <div class="w-7 h-7 rounded-full bg-emerald-500 flex items-center justify-center">
                             <div class="w-3 h-3 rounded-full bg-white opacity-60"></div>
                        </div>
                        <span class="text-lg font-bold tracking-tight text-gray-900">Klinik <span class="font-normal text-emerald-600">Medika</span></span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Akses Dashboard</h2>
                    <p class="text-gray-600 mt-2">Selamat datang kembali! Masukkan kredensial Anda.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <x-text-input id="email" class="block mt-1 w-full pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg h-12" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-sm text-emerald-600 hover:text-emerald-700 font-medium" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <x-text-input id="password" class="block mt-1 w-full pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg h-12" type="password" name="password" required placeholder="Min. 8 karakter" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="remember_me" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <label for="remember_me" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold h-12 rounded-lg shadow-md transition duration-150 flex items-center justify-center gap-2">
                            Masuk
                        </button>
                    </div>

                    <div class="mt-10 text-center border-t pt-8">
                        <p class="text-gray-600">Baru disini?</p>
                        <a href="{{ route('register') }}" class="mt-3 inline-flex items-center justify-center w-full bg-emerald-100 hover:bg-emerald-200 text-emerald-800 font-semibold h-12 rounded-lg transition duration-150 gap-2 border border-emerald-200">
                            Buat Akun Baru
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-guest-layout>