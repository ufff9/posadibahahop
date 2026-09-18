<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class LaporanPenjualan extends Component
{
    public string $tanggalDari = '';

    public string $tanggalSampai = '';

    public ?int $detailId = null;

    public function mount()
    {
        $this->tanggalDari = now()->startOfMonth()->format('Y-m-d');
        $this->tanggalSampai = now()->format('Y-m-d');
    }

    public function lihatDetail($id)
    {
        $this->detailId = $id;
    }

    protected function queryTransaksi()
    {
        return Transaksi::with('user', 'detail.barang')
            ->whereDate('created_at', '>=', $this->tanggalDari)
            ->whereDate('created_at', '<=', $this->tanggalSampai)
            ->latest()
            ->get();
    }

    public function export()
    {
        $transaksis = $this->queryTransaksi();
        $namaFile = 'laporan-penjualan-'.$this->tanggalDari.'_sampai_'.$this->tanggalSampai.'.csv';

        return response()->streamDownload(function () use ($transaksis) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Kode', 'Tanggal', 'Kasir', 'Total', 'Bayar', 'Kembalian']);
            foreach ($transaksis as $t) {
                fputcsv($out, [
                    $t->kode,
                    $t->created_at->format('Y-m-d H:i'),
                    $t->user->name,
                    $t->total,
                    $t->bayar,
                    $t->kembalian,
                ]);
            }
            fclose($out);
        }, $namaFile, ['Content-Type' => 'text/csv']);
    }

    public function render()
    {
        $transaksis = $this->queryTransaksi();
        $totalOmzet = $transaksis->sum('total');
        $jumlahTransaksi = $transaksis->count();
        $detail = $this->detailId
            ? Transaksi::with('detail.barang', 'user')->find($this->detailId)
            : null;

        return view('livewire.laporan-penjualan', compact(
            'transaksis',
            'totalOmzet',
            'jumlahTransaksi',
            'detail'
        ));
    }
}
