<?php

use App\Livewire\Kasir;
use App\Livewire\KelolaKategori;
use App\Livewire\RiwayatTransaksi;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('melarang kasir membuka halaman barang', function () {
    $kasir = User::factory()->create(['role' => 'kasir']);

    $this->actingAs($kasir)->get('/barang')->assertForbidden();
});

it('mengizinkan admin membuka halaman barang', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)->get('/barang')->assertOk();
});

it('bisa menambah kategori', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    Livewire::test(KelolaKategori::class)
        ->set('nama', 'Makanan')
        ->call('simpan');

    $this->assertDatabaseHas('kategori', ['nama' => 'Makanan']);
});

it('mengurangi stok setelah transaksi', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $kategori = Kategori::create(['nama' => 'Minuman']);
    $barang = Barang::create([
        'kategori_id' => $kategori->id,
        'kode' => 'TB1',
        'nama' => 'Teh Botol',
        'harga' => 5000,
        'stok' => 10,
    ]);

    $this->actingAs($admin);

    Livewire::test(Kasir::class)
        ->call('tambahKeKeranjang', $barang->id)
        ->set('bayar', 5000)
        ->call('proses');

    expect($barang->fresh()->stok)->toBe(9);
    expect(Transaksi::count())->toBe(1);
});

it('mengembalikan stok saat transaksi dibatalkan', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $kategori = Kategori::create(['nama' => 'Minuman']);
    $barang = Barang::create([
        'kategori_id' => $kategori->id,
        'kode' => 'TB1',
        'nama' => 'Teh Botol',
        'harga' => 5000,
        'stok' => 10,
    ]);

    $this->actingAs($admin);

    Livewire::test(Kasir::class)
        ->call('tambahKeKeranjang', $barang->id)
        ->set('bayar', 5000)
        ->call('proses');

    expect($barang->fresh()->stok)->toBe(9);

    $transaksi = Transaksi::first();

    Livewire::test(RiwayatTransaksi::class)
        ->call('batalkan', $transaksi->id);

    expect($barang->fresh()->stok)->toBe(10);
    expect($transaksi->fresh()->status)->toBe('dibatalkan');
});