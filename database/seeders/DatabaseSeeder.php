<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< HEAD
         User::factory(10)->create();
         Product::factory(20)->create();
=======
         \App\Models\User::factory(10)->create();

         $this->call([
             RoleSeeder::class
         ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
>>>>>>> 7697ef8bfebcd35431649573b32fa369a71e60e9
    }
}
