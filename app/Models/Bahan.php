<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bahan extends Model
{
    use SoftDeletes;

    protected $table = 'bahan';

    protected $fillable = [
        'nama',
        'jumlah_min',
        'satuan_id',
    ];

    public function satuan(): BelongsTo
    {
        return $this->belongsTo(Satuan::class);
    }
}
