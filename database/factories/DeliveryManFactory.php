<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeliveryMan>
 */
class DeliveryManFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->each(function($user){
                $user->roles()->attach(4);
            }),
            'code' => $this->faker->randomLetter() . $this->faker->randomLetter(),
            'shipping_cost' => rand(0, 1500),
        ];
    }
}
