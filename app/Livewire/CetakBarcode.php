<?php

namespace App\Livewire;

use App\Models\Barang;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class CetakBarcode extends Component
{
    public string $cari = '';

    public function render()
    {
        $barangs = Barang::when($this->cari, function ($query) {
            $query->where('nama', 'like', '%'.$this->cari.'%')
                ->orWhere('kode', 'like', '%'.$this->cari.'%');
        })->orderBy('nama')->get();

        return view('livewire.cetak-barcode', compact('barangs'));
    }
}
