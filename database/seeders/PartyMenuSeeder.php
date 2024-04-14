<?php

namespace Database\Seeders;

use App\Models\Party;
use App\Models\PartyMenu;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Seeder;

class PartyMenuSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Party::all()->each(function ($item) {
            PartyMenu::create([
                'party_id' => $item->id
            ]);
        });
    }
}
