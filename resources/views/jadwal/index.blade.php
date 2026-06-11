<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Jadwal Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('jadwal.create') }}" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded shadow transition duration-150">
                    + Tambah Jadwal Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border-b-2 p-3 font-semibold text-gray-700">No</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Nama Dokter</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Hari</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Jam Praktik</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwals as $index => $jadwal)
                                <tr class="border-b hover:bg-slate-50 transition-colors">
                                    <td class="p-4 text-slate-600">{{ $index + 1 }}</td>
                                    <td class="p-4 font-medium text-slate-900">{{ $jadwal->nama_dokter }}</td>
                                    <td class="p-4 text-slate-600">
                                        <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                        </span>
                                    </td>
                                    <td class="p-4 flex gap-2">
                                        <button class="text-emerald-600 hover:text-emerald-800 font-medium text-sm">Edit</button>
                                        <button class="text-red-600 hover:text-red-800 font-medium text-sm">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="border-b p-6 text-center text-slate-500" colspan="5">
                                        Belum ada data jadwal dokter. Silakan tambah jadwal baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>