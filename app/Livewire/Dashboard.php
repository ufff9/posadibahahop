<?php

namespace App\Livewire;

use App\Models\Barang;
use App\Models\Transaksi;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $penjualanHariIni = Transaksi::whereDate('created_at', today())
            ->where('status', 'selesai')
            ->sum('total');

        $jumlahTransaksi = Transaksi::whereDate('created_at', today())
            ->where('status', 'selesai')
            ->count();

        $totalBarang = Barang::count();

        $stokMenipis = Barang::with('kategori')
            ->where('stok', '<=', 5)
            ->orderBy('stok')
            ->get();

        // Data grafik: penjualan 7 hari terakhir
        $labels = [];
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = today()->subDays($i);
            $labels[] = $tanggal->format('d/m');
            $data[] = Transaksi::whereDate('created_at', $tanggal)
                ->where('status', 'selesai')
                ->sum('total');
        }

        return view('livewire.dashboard', compact(
            'penjualanHariIni',
            'jumlahTransaksi',
            'totalBarang',
            'stokMenipis',
            'labels',
            'data'
        ));
    }
}
