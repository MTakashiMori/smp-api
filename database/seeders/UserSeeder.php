<?php

namespace Database\Seeders;

use App\Models\Financial;
use App\Models\Party;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $mails = [
            'admin@mail.com',
            'manager@mail.com',
            'accounting@mail.com',
            'sales@mail.com',
        ];

        foreach ($mails as $mail) {
            User::create([
                'name' => fake()->name(),
                'email' => $mail,
                'email_verified_at' => now(),
//            'password' => '5f4dcc3b5aa765d61d8327deb882cf99', // password
                'password' => Hash::make('password'), // password
                'remember_token' => Str::random(10),
            ]);
        }

    }
}
