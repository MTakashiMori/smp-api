<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Database\Seeder;

class RoleUsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $users = User::all();

        $superAdminRole = Role::where('name', 'Super Admin')->first();

        foreach ($users as $user) {
            RoleUser::create([
                'user_id' => $user->id,
                'role_id' => $superAdminRole->id,
            ]);
        }

    }
}
