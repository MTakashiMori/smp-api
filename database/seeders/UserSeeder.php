<?php

namespace Database\Seeders;

use App\Models\User;
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

        for ($i = 0; $i <= 10; $i++) {
            $mails[] = fake('pt_BR')->email;
        }

        foreach ($mails as $mail) {
            User::create([
                'name' => fake('pt_BR')->name(),
                'email' => $mail,
                'email_verified_at' => now(),
                'cpf' => fake('pt_BR')->cpf(),
                'address' => fake('pt_BR')->address(),
                'telephone' => fake('pt_BR')->phoneNumber(),
//            'password' => '5f4dcc3b5aa765d61d8327deb882cf99', // password
                'password' => Hash::make('password'), // password
                'remember_token' => Str::random(10),
            ]);
        }

    }
}
