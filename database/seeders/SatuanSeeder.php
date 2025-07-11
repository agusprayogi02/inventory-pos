<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Satuan::create([
            'nama' => 'Gram',
            'keterangan' => 'Gram',
        ]);
        Satuan::create([
            'nama' => 'Pcs',
            'keterangan' => 'Pcs',
        ]);
        Satuan::create([
            'nama' => 'Box',
            'keterangan' => 'Box',
        ]);
    }
}
