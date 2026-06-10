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
                            <tr>
                                <td class="border-b p-3 text-center text-gray-500" colspan="5">
                                    Belum ada data jadwal dokter.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>