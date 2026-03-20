<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $roles = Role::where('name', 'Super Admin')->first();

        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            PermissionRole::create([
                'permission_id' => $permission->id,
                'role_id' => $roles->id,
            ]);
        }

        $roles = Role::where('name', 'Seller')->first();

        $permission = Permission::where('name', 'product.sell')->first();

        PermissionRole::create([
            'role_id' => $roles->id,
            'permission_id' => $permission->id,
        ]);

    }
}
