<?php

namespace App\Livewire;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Kasir extends Component
{
    public string $cari = '';

    public array $keranjang = [];

    public $bayar = '';

    public ?int $transaksiTerakhirId = null;

    public string $metodeBayar = 'tunai';

    public function tambahKeKeranjang($barangId)
    {
        $barang = Barang::findOrFail($barangId);

        if (isset($this->keranjang[$barangId])) {
            if ($this->keranjang[$barangId]['jumlah'] < $barang->stok) {
                $this->keranjang[$barangId]['jumlah']++;
            } else {
                $this->dispatch('toast', message: 'Stok '.$barang->nama.' tidak cukup.', type: 'error');
            }
        } else {
            if ($barang->stok < 1) {
                $this->dispatch('toast', message: 'Stok '.$barang->nama.' habis.', type: 'error');

                return;
            }
            $this->keranjang[$barangId] = [
                'nama' => $barang->nama,
                'foto' => $barang->foto,
                'harga' => $barang->harga,
                'jumlah' => 1,
                'stok' => $barang->stok,
            ];
        }

        $this->cari = '';
    }

    public function scanBarcode($kode)
    {
        $barang = Barang::where('kode', $kode)->first();

        if (! $barang) {
            $this->dispatch('toast', message: 'Barang dengan barcode '.$kode.' tidak ditemukan.', type: 'error');

            return;
        }

        $this->tambahKeKeranjang($barang->id);
        $this->dispatch('toast', message: $barang->nama.' ditambahkan.', type: 'success');
    }

    public function tambahJumlah($barangId)
    {
        if ($this->keranjang[$barangId]['jumlah'] < $this->keranjang[$barangId]['stok']) {
            $this->keranjang[$barangId]['jumlah']++;
        } else {
            $this->dispatch('toast', message: 'Stok tidak cukup.', type: 'error');
        }
    }

    public function kurangiJumlah($barangId)
    {
        if ($this->keranjang[$barangId]['jumlah'] > 1) {
            $this->keranjang[$barangId]['jumlah']--;
        } else {
            $this->hapusDariKeranjang($barangId);
        }
    }

    public function hapusDariKeranjang($barangId)
    {
        unset($this->keranjang[$barangId]);
    }

    public function proses()
    {
        if (count($this->keranjang) === 0) {
            $this->dispatch('toast', message: 'Keranjang masih kosong.', type: 'error');

            return;
        }

        $total = collect($this->keranjang)->sum(fn ($item) => $item['harga'] * $item['jumlah']);

        // Untuk non-tunai, bayar dianggap pas dengan total
        if ($this->metodeBayar !== 'tunai') {
            $this->bayar = $total;
        }

        $this->validate([
            'bayar' => 'required|integer|min:'.$total,
            'metodeBayar' => 'required|in:tunai,qris,transfer',
        ], [
            'bayar.required' => 'Masukkan jumlah uang bayar.',
            'bayar.integer' => 'Uang bayar harus berupa angka.',
            'bayar.min' => 'Uang bayar kurang dari total belanja.',
        ]);

        $transaksi = DB::transaction(function () use ($total) {
            $transaksi = Transaksi::create([
                'user_id' => auth()->user()->id,
                'kode' => 'TRX-'.now()->format('YmdHis').'-'.strtoupper(Str::random(4)),
                'total' => $total,
                'bayar' => $this->bayar,
                'kembalian' => $this->bayar - $total,
                'metode_bayar' => $this->metodeBayar,
            ]);

            foreach ($this->keranjang as $barangId => $item) {
                $transaksi->detail()->create([
                    'barang_id' => $barangId,
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['jumlah'],
                ]);

                Barang::find($barangId)->decrement('stok', $item['jumlah']);
            }

            return $transaksi;
        });

        $kembalian = $this->bayar - $total;

        $this->transaksiTerakhirId = $transaksi->id;

        $this->reset(['keranjang', 'bayar', 'cari']);
        $this->metodeBayar = 'tunai';

        $this->dispatch('toast', message: 'Transaksi berhasil! Kembalian: Rp '.number_format($kembalian, 0, ',', '.'), type: 'success');

        $this->dispatch('transaksi-selesai');
    }

    public function render()
    {
        $hasilCari = collect();
        if (strlen($this->cari) >= 1) {
            $hasilCari = Barang::where('nama', 'like', '%'.$this->cari.'%')
                ->orWhere('kode', 'like', '%'.$this->cari.'%')
                ->limit(8)
                ->get();
        }

        $total = collect($this->keranjang)->sum(fn ($item) => $item['harga'] * $item['jumlah']);

        $kembalian = is_numeric($this->bayar) ? max(0, (int) $this->bayar - $total) : 0;

        return view('livewire.kasir', compact('hasilCari', 'total', 'kembalian'));
    }
}
