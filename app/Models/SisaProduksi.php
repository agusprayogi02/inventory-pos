<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SisaProduksi extends Model
{
    use SoftDeletes;
    protected $table = "sisa_produksi";

    protected $fillable = [
        'tanggal',
        'produk_id',
        'jumlah',
        'status',
        'keterangan',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
