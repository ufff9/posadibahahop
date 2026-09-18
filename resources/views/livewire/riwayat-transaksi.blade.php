<div>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Transaksi</h1>

    <div class="mb-4">
        <input type="text" wire:model.live="cari" placeholder="Cari kode transaksi..."
            class="w-full max-w-sm border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm min-w-[600px]">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="p-3">Kode</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Kasir</th>
                    <th class="p-3 text-right">Total</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($transaksis as $t)
                <tr class="{{ $t->status === 'dibatalkan' ? 'bg-red-50' : '' }}">
                    <td class="p-3 font-mono text-xs">{{ $t->kode }}</td>
                    <td class="p-3">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-3">{{ $t->user->name }}</td>
                    <td class="p-3 text-right">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td class="p-3 text-center">
                        @if ($t->status === 'dibatalkan')
                        <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">Dibatalkan</span>
                        @else
                        <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">Selesai</span>
                        @endif
                    </td>
                    <td class="p-3 text-center whitespace-nowrap">
                        <button wire:click="lihatDetail({{ $t->id }})"
                            class="text-blue-600 hover:underline">Detail</button>
                        @if ($t->status !== 'dibatalkan')
                        <button wire:click="batalkan({{ $t->id }})"
                            wire:confirm="Batalkan transaksi ini? Stok barang akan dikembalikan."
                            class="text-red-600 hover:underline ml-2">Batalkan</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-gray-400">
                        Belum ada transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal detail --}}
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
                · {{ strtoupper($detail->metode_bayar) }}
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
                <div class="flex justify-between"><span>Status</span>
                    <span class="font-medium {{ $detail->status === 'dibatalkan' ? 'text-red-600' : 'text-green-600' }}">
                        {{ ucfirst($detail->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>