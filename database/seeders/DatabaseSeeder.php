<?php

namespace Database\Seeders;

use App\Models\PackageStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
                UserSeeder::class,
                RoleSeeder::class,
                UserRoleSeeder::class,
                PermissionSeeder::class,
                CategorySeeder::class,
                CountrySeeder::class,
                CustomerSeeder::class,
                OrderStatusSeeder::class,
                PackageStatusSeeder::class,
                DeliveryServiceSeeder::class,
                ProductSeeder::class,
                MessageTemplateSeeder::class,
                DeliveryManSeeder::class,
            ]);
    }
}
