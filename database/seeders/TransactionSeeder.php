<?php

namespace Database\Seeders;

use App\Constants\TransactionsStatusConstants;
use App\Models\Financial;
use App\Models\FinancialCategories;
use App\Models\Transactions;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TransactionSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Financial::all()->each(function ($item) {

            $category = FinancialCategories::where('financial_id', $item->id)->get();

            $transactionQuantity = rand(10, 50);

            for($i = 0; $i <= $transactionQuantity; $i++) {

                $faker = Faker::create();

                $price = $faker->randomFloat(1, 10, 300);

                Transactions::create([
                    'financial_id' => $item->id,
                    'name' => $faker->word(),
                    'description' => (rand(0,1) == 1 ? $faker->words(3, true) : ''),
                    'value' => (rand(0,1) == 1 ? $price : $price * -1),
                    'financial_categories_id' => $category->random()->id,
                    'status' => TransactionsStatusConstants::getRandomStatus(),
                ]);
            }
        });
    }
}
