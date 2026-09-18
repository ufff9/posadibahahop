<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
 * @mixin \Eloquent
 */
class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = ['user_id', 'kode', 'total', 'bayar', 'kembalian', 'metode_bayar', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
