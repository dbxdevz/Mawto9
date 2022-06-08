<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'first_name' => 'Tester',
            'last_name' => 'Tester',
            'address' => 'Abaya 05',
            'phone' => '77474991203',
            'country_id' => 1,
            'city_id' => 1,
        ]);
    }
}
