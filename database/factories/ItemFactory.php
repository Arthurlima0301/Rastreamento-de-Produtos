<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Item;
use App\Models\Supply;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => fake()->numberBetween(1, 999),
            'invoice_id' => Invoice::factory(),
            'supply_id' => Supply::factory(),
            'quantity' => fake()->numberBetween(1, 500),
        ];
    }
}
