<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Laporan Penjualan</h1>
        <button wire:click="export"
            class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" />
            </svg>
            Ekspor CSV
        </button>
    </div>

    {{-- Filter tanggal --}}
    <div class="bg-white rounded-lg shadow p-4 mb-6 flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm mb-1 text-gray-600">Dari Tanggal</label>
            <input type="date" wire:model.live="tanggalDari"
                class="border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
        </div>
        <div>
            <label class="block text-sm mb-1 text-gray-600">Sampai Tanggal</label>
            <input type="date" wire:model.live="tanggalSampai"
                class="border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-sm text-gray-500">Total Omzet</div>
            <div class="text-2xl font-bold text-green-600">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-sm text-gray-500">Jumlah Transaksi</div>
            <div class="text-2xl font-bold">{{ $jumlahTransaksi }}</div>
        </div>
    </div>

    {{-- Tabel transaksi --}}
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm min-w-[600px]">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="p-3">Kode</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Kasir</th>
                    <th class="p-3 text-right">Total</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($transaksis as $t)
                <tr>
                    <td class="p-3 font-mono text-xs">{{ $t->kode }}</td>
                    <td class="p-3">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-3">{{ $t->user->name }}</td>
                    <td class="p-3 text-right">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td class="p-3 text-center">
                        <button wire:click="lihatDetail({{ $t->id }})"
                            class="text-blue-600 hover:underline">Detail</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-400">
                        Tidak ada transaksi pada rentang tanggal ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal detail transaksi --}}
    @if ($detail)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50"
        wire:click.self="$set('detailId', null)">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-lg font-bold">Detail Transaksi</h2>
                    <p class="text-sm text-gray-500 font-mono">{{ $detail->kode }}</p>
                </div>
                <button wire:click="$set('detailId', null)"
                    class="text-gray-400 hover:text-gray-700">✕</button>
            </div>

            <div class="text-sm text-gray-600 mb-3">
                {{ $detail->created_at->format('d/m/Y H:i') }} · Kasir: {{ $detail->user->name }}
            </div>

            <table class="w-full text-sm mb-4">
                <thead class="text-left text-gray-500 border-b">
                    <tr>
                        <th class="py-1">Barang</th>
                        <th class="py-1 text-center">Qty</th>
                        <th class="py-1 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detail->detail as $item)
                    <tr class="border-b">
                        <td class="py-1">{{ $item->barang->nama ?? 'Barang dihapus' }}</td>
                        <td class="py-1 text-center">{{ $item->jumlah }}</td>
                        <td class="py-1 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="space-y-1 text-sm border-t pt-3">
                <div class="flex justify-between"><span>Total</span>
                    <span class="font-bold">Rp {{ number_format($detail->total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between"><span>Bayar</span>
                    <span>Rp {{ number_format($detail->bayar, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between"><span>Kembalian</span>
                    <span>Rp {{ number_format($detail->kembalian, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between"><span>Metode</span>
                    <span class="font-medium">{{ strtoupper($detail->metode_bayar) }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>