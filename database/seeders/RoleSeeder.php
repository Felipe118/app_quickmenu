<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(["name"=> RoleEnum::ADMIM_MASTER->value, 'guard_name' => 'api']);
        Role::create(["name"=> RoleEnum::ADMIN_RESTAURANT->value, 'guard_name' => 'api']);
        Role::create(["name"=> RoleEnum::USER_RESTAURANT->value, 'guard_name' => 'api']);
        Role::create( ["name"=> RoleEnum::USER->value, 'guard_name' => 'api']);       
    }
}
