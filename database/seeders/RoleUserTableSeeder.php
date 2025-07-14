<?php

namespace Database\Seeders;

use App\Enums\RoleNameEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $admin->assignRole(RoleNameEnum::ADMIN->value);
    }
}
