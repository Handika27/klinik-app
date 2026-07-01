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

                    <!-- Struk Pembayaran -->
                    @if(optional($rekam->reservasi)->status_pembayaran === 'lunas')
                    <div class="mt-8 pt-6 border-t">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Struk Pembayaran</h3>
                        
                        <!-- Badge Status -->
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                LUNAS
                            </span>
                        </div>

                        <!-- Resep Obat -->
                        @if($rekam->resepObats && $rekam->resepObats->count() > 0)
                        <div class="mb-4">
                            <h4 class="font-semibold text-gray-700 mb-2">Rincian Obat</h4>
                            <div class="border rounded-lg overflow-hidden overflow-x-auto">
                                @php 
                                    $totalObat = 0; 
                                    $jasaDokter = 50000; 
                                @endphp
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="p-3 font-semibold text-gray-700 text-sm">Nama Obat</th>
                                            <th class="p-3 font-semibold text-gray-700 text-sm">Aturan Pakai</th>
                                            <th class="p-3 font-semibold text-gray-700 text-sm">Jumlah</th>
                                            <th class="p-3 font-semibold text-gray-700 text-sm">Harga Satuan</th>
                                            <th class="p-3 font-semibold text-gray-700 text-sm">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($rekam->resepObats as $resep)
                                            @php 
                                                $subtotal = (optional($resep->obat)->harga ?? 0) * $resep->jumlah;
                                                $totalObat += $subtotal;
                                            @endphp
                                        <tr>
                                            <td class="p-3 text-sm">{{ optional($resep->obat)->nama_obat ?? 'Obat tidak ditemukan' }}</td>
                                            <td class="p-3 text-sm">{{ $resep->aturan_pakai ?? '-' }}</td>
                                            <td class="p-3 text-sm">{{ $resep->jumlah }}</td>
                                            <td class="p-3 text-sm">Rp {{ number_format(optional($resep->obat)->harga ?? 0, 0, ',', '.') }}</td>
                                            <td class="p-3 text-sm">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                        <!-- Biaya Penanganan -->
                                        <tr class="border-t-2 border-gray-300">
                                            <td colspan="4" class="p-3 text-sm font-medium text-gray-700">Biaya Penanganan (Jasa Dokter)</td>
                                            <td class="p-3 text-sm font-medium text-gray-700">Rp {{ number_format($jasaDokter, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <!-- Grand Total -->
                                        <tr class="bg-gray-100">
                                            <td colspan="4" class="p-4 text-lg font-bold text-gray-800">Grand Total Pembayaran</td>
                                            <td class="p-4 text-lg font-extrabold text-indigo-700">
                                                Rp {{ number_format($totalObat + $jasaDokter, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        @else
                            <!-- Jika tidak ada resep obat -->
                            @php $jasaDokter = 50000; @endphp
                            <div class="border rounded-lg p-4 mb-4">
                                <table class="w-full">
                                    <tbody>
                                        <tr class="border-b">
                                            <td class="py-2 font-medium text-gray-700">Biaya Penanganan (Jasa Dokter)</td>
                                            <td class="py-2 text-right text-gray-700">Rp {{ number_format($jasaDokter, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-100">
                                            <td class="p-4 text-lg font-bold text-gray-800">Grand Total Pembayaran</td>
                                            <td class="p-4 text-right text-lg font-extrabold text-indigo-700">
                                                Rp {{ number_format($jasaDokter, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif

                    </div>
                    @else
                    <!-- Peringatan Belum Lunas -->
                    <div class="mt-8 pt-6 border-t">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-orange-100 text-orange-800">
                                BELUM LUNAS - Silakan bayar di kasir
                            </span>
                        </div>
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                            <p class="font-medium">Pembayaran belum lunas</p>
                            <p class="text-sm mt-1">Silakan selesaikan pembayaran di kasir klinik untuk melihat rincian pembayaran lengkap.</p>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Tombol WhatsApp Floating -->
    <x-whatsapp-button />
</x-app-layout>
