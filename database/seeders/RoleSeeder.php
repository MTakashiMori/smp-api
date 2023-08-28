<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (['Super Admin', 'Admin', 'User', 'Seller'] as $item) {
            \App\Models\Role::factory()->create([
                'name' => $item,
            ]);
        }
    }
}
