<?php

namespace App\Livewire;

use App\Models\Barang;
use App\Models\StokMasuk as StokMasukModel;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class StokMasuk extends Component
{
    public $barang_id = '';

    public $jumlah = '';

    public string $keterangan = '';

    public function simpan()
    {
        $this->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'barang_id.required' => 'Pilih barang dulu.',
            'jumlah.min' => 'Jumlah minimal 1.',
        ]);

        DB::transaction(function () {
            StokMasukModel::create([
                'barang_id' => $this->barang_id,
                'user_id' => auth()->id(),
                'jumlah' => $this->jumlah,
                'keterangan' => $this->keterangan,
            ]);

            Barang::find($this->barang_id)->increment('stok', $this->jumlah);
        });

        $this->reset(['barang_id', 'jumlah', 'keterangan']);

        $this->dispatch('toast', message: 'Stok berhasil ditambahkan.', type: 'success');
    }

    public function render()
    {
        $barangs = Barang::orderBy('nama')->get();
        $riwayat = StokMasukModel::with('barang', 'user')->latest()->limit(20)->get();

        return view('livewire.stok-masuk', compact('barangs', 'riwayat'));
    }
}
