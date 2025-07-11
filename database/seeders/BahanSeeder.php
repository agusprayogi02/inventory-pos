<?php

namespace Database\Seeders;

use App\Models\Bahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bahan::create([
            'nama' => 'Tepung Terigu',
            'satuan_id' => 1,
            'jumlah_min' => 100,
        ]);
        Bahan::create([
            'nama' => 'Gula Pasir',
            'satuan_id' => 1,
            'jumlah_min' => 100,
        ]);
        Bahan::create([
            'nama' => 'Telur',
            'satuan_id' => 1,
            'jumlah_min' => 100,
        ]);
        Bahan::create([
            'nama' => 'Susu Bubuk',
            'satuan_id' => 1,
            'jumlah_min' => 100,
        ]);
        Bahan::create([
            'nama' => 'Susu Cair',
            'satuan_id' => 1,
            'jumlah_min' => 100,
        ]);
    }
}
