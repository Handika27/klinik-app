<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->role === 'dokter' ? __('Jadwal Praktik Saya') : __('Kelola Jadwal Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(auth()->user()->role === 'admin')
            <div class="mb-4 flex items-center gap-4">
                <a href="{{ route('jadwal.create') }}" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded shadow transition duration-150">
                    + Tambah Jadwal Baru
                </a>
                <form action="{{ route('jadwal.syncUsers') }}" method="POST" onsubmit="return confirm('Jalankan sinkronisasi jadwal dengan daftar dokter?');">
                    @csrf
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-800 text-white font-bold py-2 px-4 rounded shadow transition duration-150">Sinkronisasi Dokter</button>
                </form>
            </div>
            @endif
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border-b-2 p-3 font-semibold text-gray-700">No</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Nama Dokter</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Hari</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Jam Praktik</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Status</th>
                                @if(auth()->user()->role === 'admin')
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwals as $index => $jadwal)
                                <tr class="border-b hover:bg-slate-50 transition-colors">
                                    <td class="p-4 text-slate-600">{{ $index + 1 }}</td>
                                    <td class="p-4 font-medium text-slate-900">{{ $jadwal->nama_dokter }}</td>
                                    
                                    <!-- Kolom Hari yang sebelumnya terlewat kini ditambahkan -->
                                    <td class="p-4 text-slate-600 font-medium">{{ $jadwal->hari }}</td>
                                    
                                    <td class="p-4 text-slate-600">
                                        <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                        </span>
                                    </td>
                                    
                                    <td class="p-4">
                                        @if($jadwal->status === 'aktif')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 whitespace-nowrap">
                                                <svg class="w-3 h-3 mr-1.5 text-green-500 fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 whitespace-nowrap">
                                                <svg class="w-3 h-3 mr-1.5 text-red-500 fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                                                Cuti
                                            </span>
                                        @endif
                                    </td>
                                    
                                    @if(auth()->user()->role === 'admin')
                                    <!-- Kolom Aksi yang sudah diubah menjadi Form Hapus -->
                                    <td class="p-4 flex gap-3 items-center">
                                        <!-- Tombol Edit sementara -->
                                        <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="text-emerald-600 hover:text-emerald-800 font-medium text-sm transition">Edit</a>
                                        
                                        <!-- Tombol Toggle Status -->
                                        <form action="{{ route('jadwal.toggleStatus', $jadwal->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status jadwal ini?');">
                                            @csrf
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-800 font-medium text-sm transition">
                                                Ubah Status
                                            </button>
                                        </form>
                                        
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal praktik ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td class="border-b p-6 text-center text-slate-500" colspan="{{ auth()->user()->role === 'admin' ? 6 : 5 }}">
                                        Belum ada data jadwal dokter.
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