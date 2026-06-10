<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jadwal Praktik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('jadwal.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="hari" class="block text-gray-700 font-bold mb-2">Hari Praktik</label>
                            <select name="hari" id="hari" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">-- Pilih Hari --</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="jam_mulai" class="block text-gray-700 font-bold mb-2">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>

                            <div>
                                <label for="jam_selesai" class="block text-gray-700 font-bold mb-2">Jam Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('jadwal.index') }}" class="text-gray-500 hover:text-gray-700 underline">
                                Batal & Kembali
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded shadow transition duration-150">
                                Simpan Jadwal
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>