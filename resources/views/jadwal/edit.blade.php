<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jadwal Praktik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Form Update menggunakan method PUT -->
                    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Input Nama Dokter -->
                        <div class="mb-4">
                            <label for="nama_dokter" class="block text-sm font-medium text-slate-700 mb-1">Nama Dokter</label>
                            <input type="text" name="nama_dokter" id="nama_dokter" value="{{ $jadwal->nama_dokter }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <!-- Input Hari -->
                        <div class="mb-4">
                            <label for="hari" class="block text-sm font-medium text-slate-700 mb-1">Hari Praktik</label>
                            <select name="hari" id="hari" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <!-- Logika agar hari lama otomatis terpilih -->
                                <option value="Senin" {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                                <option value="Selasa" {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="Rabu" {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="Kamis" {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="Jumat" {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                <option value="Sabtu" {{ $jadwal->hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                <option value="Minggu" {{ $jadwal->hari == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                            </select>
                        </div>

                        <!-- Input Jam Praktik -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="jam_mulai" class="block text-sm font-medium text-slate-700 mb-1">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai" value="{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label for="jam_selesai" class="block text-sm font-medium text-slate-700 mb-1">Jam Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai" value="{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
                            <a href="{{ route('jadwal.index') }}" class="text-gray-500 hover:text-gray-700 font-medium underline">Batal & Kembali</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150">
                                Perbarui Jadwal
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>