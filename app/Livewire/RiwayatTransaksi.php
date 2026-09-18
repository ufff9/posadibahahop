<?php

namespace App\Livewire;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class RiwayatTransaksi extends Component
{
    public string $cari = '';

    public ?int $detailId = null;

    public function lihatDetail($id)
    {
        $this->detailId = $id;
    }

    public function batalkan($id)
    {
        $transaksi = Transaksi::with('detail')->findOrFail($id);

        if ($transaksi->status === 'dibatalkan') {
            $this->dispatch('toast', message: 'Transaksi ini sudah dibatalkan.', type: 'error');

            return;
        }

        DB::transaction(function () use ($transaksi) {
            // Kembalikan stok tiap barang
            foreach ($transaksi->detail as $item) {
                $barang = Barang::find($item->barang_id);
                if ($barang) {
                    $barang->increment('stok', $item->jumlah);
                }
            }

            // Tandai transaksi sebagai dibatalkan
            $transaksi->update(['status' => 'dibatalkan']);
        });

        $this->dispatch('toast', message: 'Transaksi dibatalkan, stok dikembalikan.', type: 'success');
    }

    public function render()
    {
        $transaksis = Transaksi::with('user')
            ->when($this->cari, function ($query) {
                $query->where('kode', 'like', '%'.$this->cari.'%');
            })
            ->latest()
            ->limit(50)
            ->get();

        $detail = $this->detailId
            ? Transaksi::with('detail.barang', 'user')->find($this->detailId)
            : null;

        return view('livewire.riwayat-transaksi', compact('transaksis', 'detail'));
    }
}
