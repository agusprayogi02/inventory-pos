<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RoleNameEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use function App\Enums\getPermissionsByPrefix;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => RoleNameEnum::ADMIN->value]);
        $admin->givePermissionTo(PermissionsEnum::values());

        $gudang = Role::create(['name' => RoleNameEnum::GUDANG->value]);
        $gudang->givePermissionTo(array_merge(
            getPermissionsByPrefix("bahan"),
            getPermissionsByPrefix("satuan"),
            getPermissionsByPrefix("stok_gudang"),
            getPermissionsByPrefix("produksi"),
        ));

        $kitchen = Role::create(['name' => RoleNameEnum::KITCHEN->value]);
        $kitchen->givePermissionTo(array_merge(
            getPermissionsByPrefix("resep"),
            getPermissionsByPrefix("produk"),
            getPermissionsByPrefix("stok_kitchen"),
            getPermissionsByPrefix("produksi"),
        ));

        $packingProduk = Role::create(['name' => RoleNameEnum::PACKING->value]);
        $packingProduk->givePermissionTo(array_merge(
            getPermissionsByPrefix("produksi"),
            getPermissionsByPrefix("sisa_produksi"),
        ));
    }
}
