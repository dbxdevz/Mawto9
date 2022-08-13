<?php

namespace Database\Seeders;

use App\Models\OrderPriority;
use App\Models\OrderStatus;
use App\Models\TimeChanceCall;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priority1 = OrderPriority::create([
            'priority' => '1'
        ]);
        $priority2 = OrderPriority::create([
            'priority' => '2'
        ]);
        $priority3 = OrderPriority::create([
            'priority' => '3'
        ]);
        $priority4 = OrderPriority::create([
            'priority' => 'no call'
        ]);

        OrderStatus::create([
			'status' => 'New Order',
            'order_priority_id' => $priority1->id,
		]);
        OrderStatus::create([
			'status' => 'Confirmed',
            'order_priority_id' => $priority4->id,
		]);
        OrderStatus::create([
			'status' => 'Processed',
            'order_priority_id' => $priority4->id,
		]);
        OrderStatus::create([
			'status' => 'Ready',
            'order_priority_id' => $priority2->id,
		]);
        OrderStatus::create([
			'status' => 'Cancelled',
            'order_priority_id' => $priority4->id,
		]);
        OrderStatus::create([
			'status' => 'No Answer',
            'order_priority_id' => $priority3->id,
		]);
        OrderStatus::create([
			'status' => 'Call Later',
            'order_priority_id' => $priority3->id,
		]);
        OrderStatus::create([
			'status' => 'Returned',
            'order_priority_id' => $priority4->id,
		]);
        OrderStatus::create([
			'status' => 'Paid',
            'order_priority_id' => $priority4->id,
		]);
        OrderStatus::create([
			'status' => 'Closed',
            'order_priority_id' => $priority4->id,
		]);


        //time and chance for order call
        TimeChanceCall::create([
            'chance' => 3,
        ]);
    }
}
