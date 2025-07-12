<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'sisa_produksi']);
        Permission::create(['name' => 'sisa_produksi_create']);
        Permission::create(['name' => 'sisa_produksi_edit']);
        Permission::create(['name' => 'sisa_produksi_delete']);
        Permission::create(['name' => 'sisa_produksi_view']);
        Permission::create(['name' => 'sisa_produksi_export']);
        Permission::create(['name' => 'sisa_produksi_import']);
    }
}
