<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Reservasi Pasien Saya') }}</h2>
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
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Tanggal</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Antrean</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Status</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservasis as $index => $r)
                                <tr class="border-b hover:bg-slate-50 transition-colors">
                                    <td class="p-4">{{ $index + 1 }}</td>
                                    <td class="p-4 font-medium">{{ $r->pasien->name ?? '—' }}</td>
                                    <td class="p-4">{{ $r->tanggal_kunjungan }}</td>
                                    <td class="p-4">{{ $r->nomor_antrean }}</td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 rounded text-sm font-medium {{ $r->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status == 'dikonfirmasi' ? 'bg-emerald-100 text-emerald-800' : ($r->status == 'selesai' ? 'bg-indigo-100 text-indigo-800' : 'bg-red-100 text-red-800')) }}">{{ $r->status == 'pending' ? 'Menunggu' : ($r->status == 'dikonfirmasi' ? 'Disetujui' : ($r->status == 'selesai' ? 'Selesai' : 'Batal')) }}</span>
                                    </td>
                                    <td class="p-4">
                                        <form action="{{ route('dokter.reservasi.updateStatus', $r->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <select name="status" class="border-gray-300 rounded-md mr-2">
                                                <option value="pending" {{ $r->status=='pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="dikonfirmasi" {{ $r->status=='dikonfirmasi' ? 'selected' : '' }}>Setujui</option>
                                                <option value="selesai" {{ $r->status=='selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="batal" {{ $r->status=='batal' ? 'selected' : '' }}>Tolak</option>
                                            </select>
                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded">Simpan</button>
                                        </form>
                                        @if($r->status === 'dikonfirmasi')
                                            <div class="mt-2">
                                                <a href="{{ route('dokter.rekam.create', $r->id) }}" class="inline-block text-sm text-green-700 hover:underline">Isi Rekam</a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-6 text-center text-slate-500" colspan="6">Belum ada reservasi untuk jadwal Anda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
