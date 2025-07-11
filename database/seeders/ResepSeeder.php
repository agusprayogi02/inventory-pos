<?php

namespace Database\Seeders;

use App\Models\Resep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roti = Resep::create([
            'nama' => 'Resep Roti',
            'user_id' => 1,
        ]);
        $roti->bahan()->attach(1, ['jumlah' => 150]);
        $roti->bahan()->attach(3, ['jumlah' => 140]);
        $roti->bahan()->attach(4, ['jumlah' => 100]);
        $kue = Resep::create([
            'nama' => 'Resep Kue',
            'user_id' => 1,
        ]);
        $kue->bahan()->attach(2, ['jumlah' => 150]);
        $kue->bahan()->attach(4, ['jumlah' => 300]);
        $cake = Resep::create([
            'nama' => 'Resep Cake',
            'user_id' => 1,
        ]);
        $cake->bahan()->attach(1, ['jumlah' => 150]);
        $cake->bahan()->attach(2, ['jumlah' => 100]);
        $cake->bahan()->attach(5, ['jumlah' => 100]);
    }
}
