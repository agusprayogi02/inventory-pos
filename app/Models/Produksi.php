<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produksi extends Model
{
    use SoftDeletes;

    protected $table = 'produksi';

    protected $fillable = [
        'resep_id',
        'jumlah',
        'tanggal',
    ];

    public function resep(): BelongsTo
    {
        return $this->belongsTo(Resep::class);
    }

    protected function casts(): array
    {
        return [
            'tanggal' => 'timestamp',
        ];
    }
}
