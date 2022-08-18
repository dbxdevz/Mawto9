<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Tva;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'category1'
        ]);

        Tva::create([
            'tva' => 10,
        ]);
        Tva::create([
            'tva' => 0,
        ]);

        PaymentMethod::create([
            'method' => 'Bank'
        ]);
        PaymentMethod::create([
            'method' => 'Cash'
        ]);
        PaymentMethod::create([
            'method' => 'Check'
        ]);
    }
}
