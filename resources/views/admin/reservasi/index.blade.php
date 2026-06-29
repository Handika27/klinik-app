<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Reservasi') }}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border-b-2 p-3 font-semibold text-gray-700">No</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Pasien</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Dokter</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Tanggal</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Antrean</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Status</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reservasis as $index => $r)
                                <tr class="border-b hover:bg-slate-50 transition-colors align-top">
                                    <td class="p-4 text-slate-600">{{ $index + 1 }}</td>
                                    <td class="p-4 font-medium text-slate-900">{{ $r->pasien->name ?? '—' }}</td>
                                    <td class="p-4 text-slate-600">{{ $r->jadwal->nama_dokter ?? '—' }}</td>
                                    <td class="p-4 text-slate-600">{{ \Carbon\Carbon::parse($r->tanggal_kunjungan)->format('Y-m-d') }}</td>
                                    <td class="p-4 text-slate-600">{{ $r->nomor_antrean }}</td>
                                    <td class="p-4 text-slate-600">
                                        <span class="px-2 py-1 rounded text-sm font-medium {{ $r->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status == 'dikonfirmasi' ? 'bg-emerald-100 text-emerald-800' : ($r->status == 'selesai' ? 'bg-indigo-100 text-indigo-800' : 'bg-red-100 text-red-800')) }}">{{ $r->status == 'pending' ? 'Menunggu' : ($r->status == 'dikonfirmasi' ? 'Disetujui' : ($r->status == 'selesai' ? 'Selesai' : 'Batal')) }}</span>
                                    </td>
                                    <td class="p-4">
                                        <div class="space-y-2">
                                            <form action="{{ auth()->user()->role === 'admin' ? route('admin.reservasi.updateStatus', $r->id) : route('dokter.reservasi.updateStatus', $r->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                <select name="status" class="border-gray-300 rounded-md mr-2">
                                                    <option value="pending" {{ $r->status=='pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="dikonfirmasi" {{ $r->status=='dikonfirmasi' ? 'selected' : '' }}>Setujui</option>
                                                    <option value="selesai" {{ $r->status=='selesai' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="batal" {{ $r->status=='batal' ? 'selected' : '' }}>Tolak</option>
                                                </select>
                                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded">Simpan</button>
                                            </form>
                                            @if(auth()->user()->role === 'dokter' && $r->status === 'dikonfirmasi')
                                                <a href="{{ route('dokter.rekam.create', $r->id) }}" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded">Isi Rekam</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="border-b p-6 text-center text-slate-500" colspan="7">Belum ada reservasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
