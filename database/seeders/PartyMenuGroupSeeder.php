<?php

namespace Database\Seeders;

use App\Models\Party;
use App\Models\PartyMenu;
use App\Models\PartyMenuGroup;
use App\Models\Products;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Seeder;

class PartyMenuGroupSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\pt_BR\Restaurant($faker));

        $groups = [
            'Comidas',
            'Bedidas',
            'Doces',
            'Diversos',
            'Ingressos'
        ];
        PartyMenu::all()->each(function ($item) use ($groups, $faker) {
            foreach ($groups as $group) {
                $groupId = partyMenuGroup::create([
                    'party_menu_id' => $item->id,
                    'name' => $group,
                    'color' => sprintf("#%02X%02X%02X", rand(127, 255), rand(127, 255), rand(127, 255)), //random pastel color
                    'icon' => 'fastfood'
                ]);

                for ($i = 1; $i <= rand(1,3); $i++) {
                    Products::create([
                        'party_menu_group_id' => $groupId->id,
                        'party_menu_id' => $item->id,
                        'name' => $faker->foodName(),
                        'price' => rand(1, 100),
                    ]);
                }
            }
        });
    }
}
