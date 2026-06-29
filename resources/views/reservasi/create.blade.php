<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Booking Reservasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4">
                        <h3 class="text-lg font-medium">{{ $jadwal->nama_dokter }} — {{ $jadwal->hari }}</h3>
                        <p class="text-sm text-slate-600">Jam: {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
                    </div>

                    <form action="{{ route('reservasi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">

                        <div class="mb-4">
                            <label for="tanggal_kunjungan" class="block text-sm font-medium text-slate-700 mb-1">Tanggal Kunjungan</label>
                            <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="keluhan_awal" class="block text-sm font-medium text-slate-700 mb-1">Keluhan Awal (opsional)</label>
                            <textarea name="keluhan_awal" id="keluhan_awal" rows="4" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('pasien.jadwal') }}" class="text-gray-500 hover:text-gray-700 underline">Batal & Kembali</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded shadow transition duration-150">Booking Sekarang</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
