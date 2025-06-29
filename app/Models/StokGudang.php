<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokGudang extends Model
{
    use SoftDeletes;

    protected $table = 'stok_gudang';

    protected $fillable = [
        'bahan_id',
        'user_id',
        'jumlah',
        'tanggal',
        'status',
        'keterangan',
        'exp_date',
    ];

    public function bahan(): BelongsTo
    {
        return $this->belongsTo(Bahan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'tanggal' => 'timestamp',
            'exp_date' => 'date',
        ];
    }
}
