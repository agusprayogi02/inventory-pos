<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::create([
            'resep_id' => 1,
            'satuan_id' => 2,
            'satuan_produk_id' => 3,
            'nama' => 'Roti Tawar',
            'isi' => 5,
            'jumlah' => 20,
        ]);
        Produk::create([
            'resep_id' => 1,
            'satuan_id' => 2,
            'satuan_produk_id' => 3,
            'nama' => 'Roti Bakar',
            'isi' => 5,
            'jumlah' => 20,
        ]);
        Produk::create([
            'resep_id' => 2,
            'satuan_id' => 2,
            'satuan_produk_id' => 3,
            'nama' => 'Kue Kering',
            'isi' => 5,
            'jumlah' => 20,
        ]);
        Produk::create([
            'resep_id' => 3,
            'satuan_id' => 2,
            'satuan_produk_id' => 3,
            'nama' => 'Cake Panggang',
            'isi' => 5,
            'jumlah' => 20,
        ]);
        Produk::create([
            'resep_id' => 3,
            'satuan_id' => 2,
            'satuan_produk_id' => 3,
            'nama' => 'Cake Kukus',
            'isi' => 5,
            'jumlah' => 20,
        ]);
    }
}
