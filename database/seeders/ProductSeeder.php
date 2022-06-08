<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Product 1',
            'category_id' => 1,
            'label' => 'Product 1',
            'code' => 'ZX',
            'cost_price' => 1000,
            'selling_price' => 1500,
            'description' => 'Product 1',
        ]);

        Product::create([
            'name' => 'Product 2',
            'category_id' => 1,
            'label' => 'Product 2',
            'code' => 'ZX',
            'cost_price' => 1000,
            'selling_price' => 1500,
            'description' => 'Product 2',
        ]);
    }
}
