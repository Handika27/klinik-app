<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('obat.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="nama_obat" class="block text-sm font-medium text-slate-700 mb-1">Nama Obat</label>
                            <input type="text" name="nama_obat" id="nama_obat" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Contoh: Paracetamol 500mg">
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="stok" class="block text-sm font-medium text-slate-700 mb-1">Stok</label>
                                <input type="number" name="stok" id="stok" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required min="0" value="0">
                            </div>

                            <div>
                                <label for="harga" class="block text-sm font-medium text-slate-700 mb-1">Harga (Rupiah)</label>
                                <input type="number" name="harga" id="harga" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required min="0" value="0">
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('obat.index') }}" class="text-gray-500 hover:text-gray-700 underline">Batal & Kembali</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded shadow transition duration-150">Simpan Obat</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
