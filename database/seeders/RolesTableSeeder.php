<?php

namespace Database\Seeders;

use App\Enums\RoleNameEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => RoleNameEnum::ADMIN->value]);
        Role::create(['name' => RoleNameEnum::GUDANG->value]);
        Role::create(['name' => RoleNameEnum::KITCHEN->value]);
        Role::create(['name' => RoleNameEnum::PACKING_PRODUK->value]);
        Role::create(['name' => RoleNameEnum::PACKING_KIRIM->value]);
    }
}
