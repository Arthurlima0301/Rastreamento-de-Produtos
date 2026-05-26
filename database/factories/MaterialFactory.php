<?php

namespace Database\Factories;

use App\Models\Material;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Material>
 */
class MaterialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'item_number' => fake()->numberBetween(1, 999),
            'shipping_code' => fake()->unique()->numberBetween(100000, 999999),
            'roll' => fake()->numberBetween(1, 999),
            'width' => fake()->numberBetween(1, 5000),
            'length' => fake()->numberBetween(1, 5000),
            'sheets' => fake()->numberBetween(1, 10000),
            'grammage' => fake()->randomFloat(2, 1, 9999.99),
            'expedition_code' => fake()->unique()->numberBetween(100000, 999999),
            'paper' => fake()->words(2, true),
            'return_lot' => fake()->numberBetween(1, 999999),
            'packages' => fake()->numberBetween(1, 999),
            'net_weight_p' => fake()->randomFloat(2, 1, 999999.99),
            'gross_weight_p' => fake()->randomFloat(2, 1, 999999.99),
        ];
    }
}
