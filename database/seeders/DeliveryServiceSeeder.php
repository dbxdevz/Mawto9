<?php

namespace Database\Seeders;

use App\Models\DeliveryService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliveryService::factory()->create([
            'code' => 'YL',
            'name' => 'YALDINE',
            'shipping_cost' => 15,
            'default' => true,
        ]);
    }
}
