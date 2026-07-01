<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Reservasi') }}
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

            <div class="overflow-x-auto bg-white rounded-lg shadow mb-8">
                @php
                    $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    $grouped_jadwal = $jadwals->groupBy('hari');
                @endphp

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-indigo-600 text-white">
                            <th class="py-3 px-4 font-semibold text-sm border-b border-indigo-700">Hari & Waktu</th>
                            <th class="py-3 px-4 font-semibold text-sm border-b border-indigo-700">Nama Dokter</th>
                            <th class="py-3 px-4 font-semibold text-sm border-b border-indigo-700">Jam Praktik</th>
                            <th class="py-3 px-4 font-semibold text-sm border-b border-indigo-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($hari_list as $hari)
                            @if(isset($grouped_jadwal[$hari]) && $grouped_jadwal[$hari]->count() > 0)
                                @php
                                    $jadwal_hari_ini = $grouped_jadwal[$hari];
                                    // Shift 1 (Pagi/Siang): Mulai sebelum jam 13:00
                                    $shift_pagi = $jadwal_hari_ini->filter(fn($j) => $j->jam_mulai < '13:00:00')->values();
                                    // Shift 2 (Sore/Malam): Mulai dari jam 13:00 ke atas
                                    $shift_sore = $jadwal_hari_ini->filter(fn($j) => $j->jam_mulai >= '13:00:00')->values();
                                @endphp

                                @if($shift_pagi->count() > 0)
                                    @foreach($shift_pagi as $index => $jadwal)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            @if($index == 0)
                                                <td class="py-3 px-4 font-medium text-gray-900 align-top bg-indigo-50/50 border-r border-gray-200" rowspan="{{ $shift_pagi->count() }}">
                                                    <div class="text-base text-indigo-700 font-bold uppercase tracking-wide">{{ $hari }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">Shift Pagi</div>
                                                </td>
                                            @endif
                                            <td class="py-3 px-4">
                                                <div class="font-medium text-gray-800">{{ $jadwal->user->name ?? ($jadwal->nama_dokter ?? 'Dokter') }}</div>
                                                @if($jadwal->status === 'cuti')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 whitespace-nowrap mt-1">
                                                        Cuti
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 whitespace-nowrap mt-1">
                                                        Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-600 font-medium">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                @if($jadwal->status == 'aktif')
                                                    <a href="{{ route('reservasi.create', $jadwal->id) }}" class="inline-flex items-center px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md shadow-sm transition-colors">Booking</a>
                                                @else
                                                    <button disabled class="inline-flex items-center px-4 py-1.5 bg-red-100 text-red-700 text-sm font-semibold rounded-md cursor-not-allowed">Cuti / Penuh</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                                @if($shift_sore->count() > 0)
                                    @foreach($shift_sore as $index => $jadwal)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            @if($index == 0)
                                                <td class="py-3 px-4 font-medium text-gray-900 align-top bg-emerald-50/50 border-r border-gray-200" rowspan="{{ $shift_sore->count() }}">
                                                    <div class="text-base text-emerald-700 font-bold uppercase tracking-wide">{{ $hari }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">Shift Sore</div>
                                                </td>
                                            @endif
                                            <td class="py-3 px-4">
                                                <div class="font-medium text-gray-800">{{ $jadwal->user->name ?? ($jadwal->nama_dokter ?? 'Dokter') }}</div>
                                                @if($jadwal->status === 'cuti')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 whitespace-nowrap mt-1">
                                                        Cuti
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 whitespace-nowrap mt-1">
                                                        Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-600 font-medium">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                @if($jadwal->status == 'aktif')
                                                    <a href="{{ route('reservasi.create', $jadwal->id) }}" class="inline-flex items-center px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-md shadow-sm transition-colors">Booking</a>
                                                @else
                                                    <button disabled class="inline-flex items-center px-4 py-1.5 bg-red-100 text-red-700 text-sm font-semibold rounded-md cursor-not-allowed">Cuti / Penuh</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tombol WhatsApp Floating -->
    <x-whatsapp-button />
</x-app-layout>