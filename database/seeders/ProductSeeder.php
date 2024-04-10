<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ([
            'Cachorro-quente',
            'Pastel de carne',
            'Pastel de queijo',
            'Pastel misto',
            'Coca-cola Lata',
            'Guaraná Lata',
            'Churrasquinho',
            ] as $item) {
                \App\Models\Product::create([
                    'name' => $item,
                    'description' => $item,
                ]
            );
        }
    }
}
