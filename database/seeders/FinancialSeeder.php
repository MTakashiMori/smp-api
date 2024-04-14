<?php

namespace Database\Seeders;

use App\Models\Financial;
use App\Models\Party;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Seeder;

class FinancialSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Party::all()->each(function ($item) {
            Financial::create([
                'party_id' => $item->id
            ]);
        });
    }
}
