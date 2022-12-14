<?php

namespace Database\Seeders;

use App\Models\DeliveryService;
use App\Models\MessageTemplate;
use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class MessageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messageTemplate = MessageTemplate::factory()
                                          ->create()
        ;
        $messageTemplate->orderStatuses()
                        ->attach(
                            OrderStatus::all()
                                       ->random(1)
                                       ->pluck('id')
                                       ->toArray()
                        )
        ;
        $messageTemplate->deliveryServices()
                        ->attach(
                            DeliveryService::all()
                                           ->random(1)
                                           ->pluck('id')
                                           ->toArray()
                        )
        ;

        $messageTemplate = MessageTemplate::factory()
                                          ->create()
        ;
        $messageTemplate->orderStatuses()
                        ->attach(
                            OrderStatus::all()
                                       ->random(1)
                                       ->pluck('id')
                                       ->toArray()
                        )
        ;
        $messageTemplate->deliveryServices()
                        ->attach(
                            DeliveryService::all()
                                           ->random(1)
                                           ->pluck('id')
                                           ->toArray()
                        )
        ;

        $messageTemplate = MessageTemplate::factory()
                                          ->create()
        ;
        $messageTemplate->orderStatuses()
                        ->attach(
                            OrderStatus::all()
                                       ->random(1)
                                       ->pluck('id')
                                       ->toArray()
                        )
        ;
        $messageTemplate->deliveryServices()
                        ->attach(
                            DeliveryService::all()
                                           ->random(1)
                                           ->pluck('id')
                                           ->toArray()
                        )
        ;
    }
}
