<?php

namespace Database\Factories;

use App\Models\SupplyInvoice;
use App\Models\SupplyItem;
use App\Models\Supply;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupplyItem>
 */
class SupplyItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => fake()->numberBetween(1, 999),
            'supply_invoice_id' => SupplyInvoice::factory(),
            'supply_id' => Supply::factory(),
            'quantity' => fake()->numberBetween(1, 500),
        ];
    }
}
