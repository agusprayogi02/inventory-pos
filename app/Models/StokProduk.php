<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokProduk extends Model
{
    use SoftDeletes;

    protected $table = 'stok_produk';

    protected $fillable = [
        'produksi_id',
        'produk_id',
        'jumlah',
        'keterangan',
    ];

    public function produksi(): BelongsTo
    {
        return $this->belongsTo(Produksi::class);
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
