<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pengumuman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('announcements.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="judul" class="block text-sm font-medium text-slate-700 mb-1">Judul Pengumuman</label>
                            <input type="text" name="judul" id="judul" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Masukkan judul pengumuman...">
                        </div>

                        <div class="mb-4">
                            <label for="konten" class="block text-sm font-medium text-slate-700 mb-1">Isi Pengumuman</label>
                            <textarea name="konten" id="konten" rows="5" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Tulis isi pengumuman di sini..."></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="tanggal_rilis" class="block text-sm font-medium text-slate-700 mb-1">Tanggal Rilis (Opsional)</label>
                                <input type="datetime-local" name="tanggal_rilis" id="tanggal_rilis" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="flex items-center pt-6">
                                <input type="checkbox" name="is_active" id="is_active" checked class="w-4 h-4 text-indigo-600 rounded focus:ring-indigo-500 border-slate-300">
                                <label for="is_active" class="ml-2 block text-sm font-medium text-slate-700">Pengumuman Aktif</label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('announcements.index') }}" class="text-gray-500 hover:text-gray-700 underline">Batal & Kembali</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded shadow transition duration-150">Simpan Pengumuman</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
