<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();

         $this->call([
             RoleSeeder::class,
             ProductSeeder::class,
             PartySeeder::class,
             PartyMenuSeeder::class,
             FinancialSeeder::class,
             FinancialCategoriesSeeder::class,
             TransactionSeeder::class
         ]);
    }
}
