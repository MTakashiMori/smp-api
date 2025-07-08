<?php

namespace Database\Seeders;

use App\Models\Financial;
use App\Models\Party;
use App\Models\Sponsor;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SponsorSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        for($i = 1; $i <= 20; $i++) {
            Sponsor::create([
                'name' => fake('pt_BR')->company(),
                'telephone' => fake('pt_BR')->phoneNumber(),
                'address' => fake('pt_BR')->address(),
                'reference' => fake('pt_BR')->name(),
            ]);
        }

    }
}
