<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
            'restaurants-list',
            'restaurants-create',
            'restaurants-edit',
            'restaurants-delete',
            'menus-list',
            'menus-create',
            'menus-edit',
            'menus-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'api');   
        }

        $admimMaster = Role::where('name',RoleEnum::ADMIM_MASTER->value)->where('guard_name', 'api')->first();
        $adminRest = Role::where('name',RoleEnum::ADMIN_RESTAURANT->value)->where('guard_name', 'api')->first();
        $userRest = Role::where('name',RoleEnum::USER_RESTAURANT->value)->where('guard_name', 'api')->first();

        $admimMaster->givePermissionTo(Permission::all());
        $adminRest->givePermissionTo([
            'restaurants-list',
            'restaurants-create',
            'restaurants-edit',
            'restaurants-delete',
            'menus-list',
            'menus-create',
            'menus-edit',
            'menus-delete',
        ]);

        $userRest->givePermissionTo([
            'restaurants-list',
            'menus-list',
        ]);

    }
}
