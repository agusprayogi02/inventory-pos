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
        'produksi_id',
        'jumlah',
    ];

    public function produksi(): BelongsTo
    {
        return $this->belongsTo(Produksi::class);
    }
}
