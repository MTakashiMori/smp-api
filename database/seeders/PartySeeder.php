<?php

namespace Database\Seeders;

use App\Models\Party;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Seeder;

class PartySeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $items = [
            'Festa Junina 2024',
            'Festa da Padroeira 2024',
            'Festa Junina 2023',
            'Festa da Padroeira 2023',
            'Festa Junina 2022',
            'Festa da Padroeira 2022',
        ];

        foreach ($items as $item) {

            $date = new DateTime();

            Party::create([
                'name' => $item,
                'start_date' => $date->format('Y-m-d'),
                'end_date' => $date->modify('+3 day')->format('Y-m-d'),
                'reference' => '',
                'address' => ''
            ]);
        }
    }
}
