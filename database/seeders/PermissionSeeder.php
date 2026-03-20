<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ([
            [
                'name' => 'party.create',
                'desc' => 'Create Party',
            ],
            [
                'name' => 'party.read',
                'desc' => 'Read Party',
            ],
            [
                'name' => 'party.update',
                'desc' => 'Update Party',
            ],
            [
                'name' => 'party.delete',
                'desc' => 'Delete Party',
            ],
            [
                'name' => 'product.create',
                'desc' => 'Create Product',
            ],
            [
                'name' => 'product.read',
                'desc' => 'Read Product',
            ],
            [
                'name' => 'product.update',
                'desc' => 'Update Product',
            ],
            [
                'name' => 'product.delete',
                'desc' => 'Delete Product',
            ],
            [
                'name' => 'product.sell',
                'desc' => 'Sell Product'
            ],
        ] as $item) {
            Permission::create([
                'name' => $item['name'],
                'description' => $item['desc'],
        ]);
        }
    }
}
