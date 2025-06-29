<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResepBahan extends Model
{
    use SoftDeletes;

    protected $table = 'resep_bahan';

    protected $fillable = [
        'resep_id',
        'bahan_id',
        'jumlah',
    ];

    public function resep(): BelongsTo
    {
        return $this->belongsTo(Resep::class);
    }

    public function bahan(): BelongsTo
    {
        return $this->belongsTo(Bahan::class);
    }
}
