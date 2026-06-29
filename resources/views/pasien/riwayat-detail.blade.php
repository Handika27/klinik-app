<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Detail Riwayat Pemeriksaan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <a href="{{ route('pasien.riwayat') }}" class="text-gray-600 hover:text-gray-800 flex items-center">
                            &larr; Kembali ke Riwayat
                        </a>
                        <span class="text-sm text-gray-500">
                            {{ $rekam->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <!-- Informasi Umum -->
                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Informasi Pemeriksaan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                            <span class="font-medium text-gray-600">Tanggal Kunjungan:</span>
                            <p class="text-gray-900">{{ optional($rekam->reservasi)->tanggal_kunjungan ?? 'Tidak tersedia' }}</p>
                            </div>
                            <div>
                            <span class="font-medium text-gray-600">Dokter:</span>
                            <p class="text-gray-900">{{ optional($rekam->dokter)->name ?? 'Tidak tersedia' }}</p>
                            </div>
                            @if($rekam->reservasi && $rekam->reservasi->jadwal)
                            <div>
                            <span class="font-medium text-gray-600">Jadwal:</span>
                            <p class="text-gray-900">{{ $rekam->reservasi->jadwal->hari }}, {{ $rekam->reservasi->jadwal->jam_mulai }} - {{ $rekam->reservasi->jadwal->jam_selesai }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Diagnosis -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Diagnosis</h3>
                        <p class="text-gray-700">{{ $rekam->diagnosis }}</p>
                    </div>

                    <!-- Tindakan -->
                    @if($rekam->tindakan)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Tindakan</h3>
                        <p class="text-gray-700">{{ $rekam->tindakan }}</p>
                    </div>
                    @endif

                    <!-- Resep Obat -->
                    @if($rekam->resepObats && $rekam->resepObats->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Resep Obat</h3>
                        <div class="border rounded-lg overflow-hidden">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-3 font-semibold text-gray-700 text-sm">Nama Obat</th>
                                        <th class="p-3 font-semibold text-gray-700 text-sm">Jumlah</th>
                                        <th class="p-3 font-semibold text-gray-700 text-sm">Aturan Pakai</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($rekam->resepObats as $resep)
                                    <tr>
                                        <td class="p-3 text-sm">{{ optional($resep->obat)->nama_obat ?? 'Obat tidak ditemukan' }}</td>
                                        <td class="p-3 text-sm">{{ $resep->jumlah }}</td>
                                        <td class="p-3 text-sm">{{ $resep->aturan_pakai }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
