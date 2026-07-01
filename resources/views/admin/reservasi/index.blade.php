<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Reservasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div id="alert-success" class="mb-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded shadow-sm transition-all duration-500 ease-in-out">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div id="alert-error" class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded shadow-sm transition-all duration-500 ease-in-out">
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
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Total Biaya</th>
                                <th class="border-b-2 p-3 font-semibold text-gray-700">Pembayaran</th>
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
                                    <td class="p-4 text-slate-600">
                                        @if($r->status == 'pending' || $r->status == 'dikonfirmasi' || $r->status == 'menunggu')
                                            <span class="text-xs text-gray-500 italic">Menunggu Pemeriksaan</span>
                                        @elseif($r->status == 'batal')
                                            <span class="text-xs text-red-500 italic">Dibatalkan</span>
                                        @else
                                            @php
                                                // Gunakan nominal dari database jika ada
                                                $total = $r->total_biaya;

                                                // Fallback Kalkulator untuk data lama yang total_biaya nya masih null
                                                if (!$total && $r->rekamMedis) {
                                                    $total = 50000; // Base price jasa dokter
                                                    foreach($r->rekamMedis->resepObats as $resep) {
                                                        if($resep->obat) {
                                                            $total += ($resep->obat->harga * $resep->jumlah);
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <span class="font-medium text-gray-800">
                                                Rp {{ number_format($total ?? 0, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-slate-600">
                                        <span class="px-2 py-1 rounded text-sm font-medium {{ $r->status_pembayaran == 'lunas' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                            {{ ucfirst($r->status_pembayaran) }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <div class="space-y-2">
                                            @if(auth()->user()->role === 'admin')
                                                @if($r->status === 'pending')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 whitespace-nowrap">
                                                        Menunggu
                                                    </span>
                                                @elseif($r->status === 'selesai' && $r->status_pembayaran === 'belum')
                                                    <button type="button" onclick="openPaymentModal({{ $r->id }})" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                        Proses Pembayaran
                                                    </button>
                                                @elseif($r->status_pembayaran === 'lunas')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 whitespace-nowrap">
                                                        Lunas ({{ ucfirst($r->metode_pembayaran) }})
                                                    </span>
                                                @endif
                                            @elseif(auth()->user()->role === 'dokter')
                                                @if($r->status == 'pending' || $r->status == 'menunggu')
                                                    <a href="{{ route('dokter.rekam.create', $r->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                                                        Proses
                                                    </a>
                                                @elseif($r->status == 'dikonfirmasi')
                                                    <a href="{{ route('dokter.rekam.create', $r->id) }}" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-1 px-3 rounded text-sm animate-pulse">
                                                        Input Rekam Medis
                                                    </a>
                                                @elseif($r->status == 'selesai')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 whitespace-nowrap">
                                                        Selesai Diperiksa
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="border-b p-6 text-center text-slate-500" colspan="9">Belum ada reservasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Pembayaran -->
    <div id="paymentModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">Proses Pembayaran</h3>
                </div>
                <div class="p-6">
                    <div id="paymentModalBody"></div>
                    <div class="mt-6 flex gap-3">
                        <button onclick="closePaymentModal()" class="flex-1 px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide alerts after 4 seconds with fade out
        document.addEventListener('DOMContentLoaded', function() {
            ['alert-success', 'alert-error'].forEach(function(alertId) {
                const alertEl = document.getElementById(alertId);
                if (alertEl) {
                    setTimeout(() => {
                        alertEl.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            alertEl.style.display = 'none';
                        }, 500);
                    }, 4000);
                }
            });
        });

        const reservasis = @json($reservasis);

        function openPaymentModal(reservasiId) {
            const r = reservasis.find(x => x.id === reservasiId);
            if (!r) return;

            let rincianObat = '';
            if (r.rekam_medis && r.rekam_medis.resep_obats) {
                r.rekam_medis.resep_obats.forEach(resep => {
                    rincianObat += `
                        <tr class="border-b">
                            <td class="py-2 text-slate-600">${resep.obat.nama_obat}</td>
                            <td class="py-2 text-slate-600 text-right">${resep.jumlah} x Rp ${new Intl.NumberFormat('id-ID').format(resep.obat.harga)}</td>
                        </tr>
                    `;
                });
            }

            const modalBody = `
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3">Rincian Biaya</h4>
                    <table class="w-full">
                        <tr class="border-b">
                            <td class="py-2 text-slate-600">Biaya Penanganan</td>
                            <td class="py-2 text-slate-600 text-right">Rp 50.000</td>
                        </tr>
                        ${rincianObat}
                        <tr class="font-semibold text-lg text-indigo-700 pt-3">
                            <td class="py-2">Total</td>
                            <td class="py-2 text-right">Rp ${new Intl.NumberFormat('id-ID').format(r.total_biaya)}</td>
                        </tr>
                    </table>
                </div>
                
                <form action="/admin/reservasi/${r.id}/bayar" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                        <select name="metode_pembayaran" required class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 h-12 px-3">
                            <option value="cash">Cash (Tunai)</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition-colors">
                        Tandai Lunas
                    </button>
                </form>
            `;

            document.getElementById('paymentModalBody').innerHTML = modalBody;
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
