<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $kategori_id
 * @property string $kode
 * @property string $nama
 * @property string|null $foto
 * @property int $harga
 * @property int $stok
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Kategori $kategori
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereUpdatedAt($value)
 */
	class Barang extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Barang> $barang
 * @property-read int|null $barang_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kategori whereUpdatedAt($value)
 */
	class Kategori extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $barang_id
 * @property int $user_id
 * @property int $jumlah
 * @property string|null $keterangan
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Barang $barang
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StokMasuk whereUserId($value)
 */
	class StokMasuk extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $kode
 * @property int $total
 * @property int $bayar
 * @property int $kembalian
 * @property string $metode_bayar
 * @property string $status
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiDetail> $detail
 * @property-read int|null $detail_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereKembalian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereMetodeBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereUserId($value)
 */
	class Transaksi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $transaksi_id
 * @property int $barang_id
 * @property int $jumlah
 * @property int $harga
 * @property int $subtotal
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Barang $barang
 * @property-read \App\Models\Transaksi $transaksi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereTransaksiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereUpdatedAt($value)
 */
	class TransaksiDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $role
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaksi> $transaksi
 * @property-read int|null $transaksi_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

