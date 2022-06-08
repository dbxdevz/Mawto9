<?php

namespace Database\Seeders;

use App\Models\PackageStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PackageStatus::create([
			'status' => 'UNPACKED',
		]);

        PackageStatus::create([
			'status' => 'PACKED',
		]);
        PackageStatus::create([
			'status' => 'SHIPPED',
		]);
        PackageStatus::create([
			'status' => 'DELIVERED',
		]);
        PackageStatus::create([
			'status' => 'READY',
		]);
        PackageStatus::create([
			'status' => 'RETURN',
		]);
        PackageStatus::create([
			'status' => 'UNKNOWN',
		]);
        PackageStatus::create([
			'status' => 'NO ANSWER',
		]);
        PackageStatus::create([
			'status' => 'POSTPONED',
		]);
        PackageStatus::create([
			'status' => 'PICKED UP',
		]);
        PackageStatus::create([
			'status' => 'REJECTED',
		]);
    }
}
