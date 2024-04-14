<?php

namespace Database\Seeders;

use App\Models\Financial;
use App\Models\FinancialCategories;
use Illuminate\Database\Seeder;

class FinancialCategoriesSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Financial::all()->each(function ($item) {
            $items = [
                'Geral',
                'Festa',
                'Atrações'
            ];

            foreach ($items as $i) {
                FinancialCategories::create([
                    'financial_id' => $item->id,
                    'name' => $i
                ]);
            }
        });
    }
}
