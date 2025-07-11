<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resep extends Model
{
    use SoftDeletes;

    protected $table = 'resep';

    protected $fillable = [
        'nama',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bahan(): BelongsToMany
    {
        return $this->belongsToMany(Bahan::class, 'resep_bahan', 'resep_id', 'bahan_id')
            ->withPivot('jumlah');
    }
}
