<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_code' => fake()->unique()->numerify('ORD-#####'),
            'client_id' => Client::factory(),
            'status' => fake()->randomElement(['ATIVA','FINALIZADA']),
        ];
    }
}
