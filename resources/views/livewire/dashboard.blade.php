<div>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>

    {{-- Kartu ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M6 8h9a3 3 0 0 1 0 6H9a3 3 0 0 0 0 6" />
                </svg>
            </div>
            <div>
                <div class="text-sm text-gray-500">Penjualan Hari Ini</div>
                <div class="text-xl font-bold">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2" />
                </svg>
            </div>
            <div>
                <div class="text-sm text-gray-500">Transaksi Hari Ini</div>
                <div class="text-xl font-bold">{{ $jumlahTransaksi }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4v10l-9 4-9-4V7z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 4 9-4M12 11v10" />
                </svg>
            </div>
            <div>
                <div class="text-sm text-gray-500">Total Jenis Barang</div>
                <div class="text-xl font-bold">{{ $totalBarang }}</div>
            </div>
        </div>
    </div>

    {{-- Grafik penjualan 7 hari --}}
    <div class="bg-white rounded-xl shadow p-5 mb-8" wire:ignore
        x-data="grafikPenjualan(@js($labels), @js($data))">
        <h2 class="font-bold text-gray-700 mb-4">Penjualan 7 Hari Terakhir</h2>
        <div class="relative" style="height: 300px;">
            <canvas x-ref="canvas"></canvas>
        </div>
    </div>

    {{-- Stok menipis --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-5 py-4 border-b font-bold flex items-center gap-2">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z" />
            </svg>
            Stok Menipis (≤ 5)
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="p-3">Kode</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3 text-right">Sisa Stok</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($stokMenipis as $barang)
                <tr>
                    <td class="p-3">{{ $barang->kode }}</td>
                    <td class="p-3">{{ $barang->nama }}</td>
                    <td class="p-3">{{ $barang->kategori->nama }}</td>
                    <td class="p-3 text-right">
                        <span class="px-2 py-1 rounded text-xs
                                {{ $barang->stok == 0 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $barang->stok }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-400">
                        Semua stok aman. 👍
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@script
<script>
    // Muat Chart.js dari CDN sekali saja
    if (!window.Chart) {
        const s = document.createElement('script');
        s.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js';
        document.head.appendChild(s);
    }

    window.grafikPenjualan = function(labels, data) {
        return {
            chart: null,
            init() {
                const buat = () => {
                    if (!window.Chart) {
                        setTimeout(buat, 100); // tunggu library termuat
                        return;
                    }
                    this.chart = new Chart(this.$refs.canvas, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Penjualan (Rp)',
                                data: data,
                                borderColor: '#2563eb',
                                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.3,
                                pointBackgroundColor: '#2563eb',
                                pointRadius: 4,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: (value) => 'Rp ' + value.toLocaleString('id-ID')
                                    }
                                }
                            }
                        }
                    });
                };
                buat();
            }
        };
    };
</script>
@endscript