<?php

namespace Database\Seeders;

use App\Models\Financial;
use App\Models\Party;
use App\Models\PartySponsor;
use App\Models\Sponsor;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PartySponsorSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $parties = Party::all();

        Sponsor::all()->each(function (Sponsor $sponsor) use ($parties) {
            for($i = 0; $i <= rand(1, 4); $i++) {
                PartySponsor::create([
                    'sponsor_id' => $sponsor->id,
                    'party_id' => $parties->random()->id,
                ]);
            }
        });

    }
}
