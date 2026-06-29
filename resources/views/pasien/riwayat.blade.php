<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Riwayat Pemeriksaan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded shadow-sm">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($riwayats->count() > 0)
                        <div class="space-y-4">
                            @foreach($riwayats as $rekam)
                                <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-semibold text-lg">{{ optional($rekam->reservasi)->tanggal_kunjungan ?? 'Tanggal tidak tersedia' }}</h3>
                                            <p class="text-sm text-gray-600">Dokter: {{ optional($rekam->dokter)->name ?? 'Nama dokter tidak tersedia' }}</p>
                                        </div>
                                        <button onclick="window.location.href='{{ route('pasien.riwayat.show', $rekam->id) }}'" class="text-blue-600 hover:text-blue-800 text-sm font-medium bg-transparent border-none cursor-pointer p-0">
                                            Lihat Detail &rarr;
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm font-medium text-gray-700">Diagnosis:</p>
                                        <p class="text-gray-600">{{ Str::limit($rekam->diagnosis, 100) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p class="text-lg">Belum ada riwayat pemeriksaan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
