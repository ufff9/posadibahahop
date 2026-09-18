<?php

use App\Livewire\CetakBarcode;
use App\Livewire\Dashboard;
use App\Livewire\Kasir;
use App\Livewire\KelolaBarang;
use App\Livewire\KelolaKategori;
use App\Livewire\KelolaUser;
use App\Livewire\LaporanPenjualan;
use App\Livewire\Login;
use App\Livewire\RiwayatTransaksi;
use App\Livewire\StokMasuk;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/login', Login::class)->name('login');

Route::post('/logout', function () {
    Auth::logout();

    return redirect('/login');
})->name('logout');

Route::get('/barang', KelolaBarang::class)
    ->middleware(['auth', 'can:admin'])
    ->name('barang');

Route::get('/kategori', KelolaKategori::class)
    ->middleware(['auth', 'can:admin'])
    ->name('kategori');

Route::get('/kasir', Kasir::class)
    ->middleware('auth')
    ->name('kasir');

Route::get('/dashboard', Dashboard::class)
    ->middleware('auth')
    ->name('dashboard');

Route::get('/laporan', LaporanPenjualan::class)
    ->middleware(['auth', 'can:admin'])
    ->name('laporan');

Route::get('/struk/{transaksi}', function (Transaksi $transaksi) {
    $transaksi->load('detail.barang', 'user');

    return view('struk', compact('transaksi'));
})->middleware('auth')->name('struk');

Route::get('/stok-masuk', StokMasuk::class)
    ->middleware(['auth', 'can:admin'])
    ->name('stok-masuk');

Route::get('/riwayat', RiwayatTransaksi::class)
    ->middleware(['auth', 'can:admin'])
    ->name('riwayat');

Route::get('/user', KelolaUser::class)
    ->middleware(['auth', 'can:admin'])
    ->name('user');

Route::get('/cetak-barcode', CetakBarcode::class)
    ->middleware(['auth', 'can:admin'])
    ->name('cetak-barcode');
