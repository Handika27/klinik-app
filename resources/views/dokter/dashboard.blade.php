<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded shadow-sm">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded shadow-sm">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-slate-900">Kelola Reservasi</h3>
                    <p class="text-sm text-slate-600 mb-6">Akses daftar reservasi pasien yang terkait dengan jadwal Anda.</p>
                    <a href="{{ route('dokter.reservasi.index') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150">Kelola Reservasi &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
