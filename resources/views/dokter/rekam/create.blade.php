<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Isi Rekam Medis & Resep') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded shadow-sm">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium">Pasien: {{ $reservasi->pasien->name ?? '—' }}</h3>
                        <p class="text-sm text-slate-600">Tanggal: {{ $reservasi->tanggal_kunjungan }} — Antrean: {{ $reservasi->nomor_antrean }}</p>
                    </div>

                    <form action="{{ route('dokter.rekam.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reservasi_id" value="{{ $reservasi->id }}">

                        <div class="mb-4">
                            <label for="diagnosis" class="block text-sm font-medium text-slate-700 mb-1">Diagnosis</label>
                            <textarea name="diagnosis" id="diagnosis" rows="4" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Resep Obat (opsional)</label>
                            <div id="resep-list">
                                <div class="grid grid-cols-3 gap-2 mb-2">
                                    <select name="obat_id[]" class="border-gray-300 rounded-md">
                                        <option value="">-- Pilih Obat --</option>
                                        @foreach($obats as $ob)
                                            <option value="{{ $ob->id }}">{{ $ob->nama_obat }} (Stok: {{ $ob->stok }})</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="jumlah[]" min="1" value="1" class="border-gray-300 rounded-md" placeholder="Jumlah">
                                    <input type="text" name="aturan_pakai[]" class="border-gray-300 rounded-md" placeholder="Aturan pakai">
                                </div>
                            </div>
                            <button type="button" id="add-resep" class="mt-2 bg-green-600 hover:bg-green-800 text-white py-1 px-3 rounded">Tambah Baris Resep</button>
                        </div>

                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('dokter.rekam.index') }}" class="text-gray-500 hover:text-gray-700 underline">Batal & Kembali</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition duration-150">Simpan Rekam</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            document.getElementById('add-resep').addEventListener('click', function(){
                const container = document.getElementById('resep-list');
                const template = `
                <div class="grid grid-cols-3 gap-2 mb-2">
                    <select name="obat_id[]" class="border-gray-300 rounded-md">
                        <option value="">-- Pilih Obat --</option>
                        @foreach($obats as $ob)
                            <option value="{{ $ob->id }}">{{ $ob->nama_obat }} (Stok: {{ $ob->stok }})</option>
                        @endforeach
                    </select>
                    <input type="number" name="jumlah[]" min="1" value="1" class="border-gray-300 rounded-md" placeholder="Jumlah">
                    <input type="text" name="aturan_pakai[]" class="border-gray-300 rounded-md" placeholder="Aturan pakai">
                </div>`;
                container.insertAdjacentHTML('beforeend', template);
            });
        });
    </script>
</x-app-layout>
