<?php

namespace Database\Seeders;

use App\Enums\StokStatus;
use App\Models\StokGudang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StokGudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StokGudang::create([
            'bahan_id' => 1,
            'user_id' => 1,
            'jumlah' => random_int(4, 50),
            'tanggal' => now(),
            'status' => StokStatus::PLUS->value,
            'keterangan' => 'Stok Gudang',
            'exp_date' => now()->addMonths(random_int(4, 12)),
        ]);
        StokGudang::create([
            'bahan_id' => 2,
            'user_id' => 1,
            'jumlah' => random_int(4, 50),
            'tanggal' => now(),
            'status' => StokStatus::PLUS->value,
            'keterangan' => 'Stok Gudang',
            'exp_date' => now()->addMonths(random_int(4, 12)),
        ]);
        StokGudang::create([
            'bahan_id' => 3,
            'user_id' => 1,
            'jumlah' => random_int(4, 50),
            'tanggal' => now(),
            'status' => StokStatus::PLUS->value,
            'keterangan' => 'Stok Gudang',
            'exp_date' => now()->addMonths(random_int(4, 12)),
        ]);
        StokGudang::create([
            'bahan_id' => 4,
            'user_id' => 1,
            'jumlah' => random_int(4, 50),
            'tanggal' => now(),
            'status' => StokStatus::PLUS->value,
            'keterangan' => 'Stok Gudang',
            'exp_date' => now()->addMonths(random_int(4, 12)),
        ]);
        StokGudang::create([
            'bahan_id' => 5,
            'user_id' => 1,
            'jumlah' => random_int(4, 50),
            'tanggal' => now(),
            'status' => StokStatus::PLUS->value,
            'keterangan' => 'Stok Gudang',
            'exp_date' => now()->addMonths(random_int(4, 12)),
        ]);
    }
}
