<?php

namespace Database\Factories;

use App\Models\Dispatch;
use App\Models\DispatchItem;
use App\Models\SupplyItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DispatchItem>
 */
class DispatchItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'dispatch_id' => Dispatch::factory(),
            'supply_item_id' => SupplyItem::factory(),
            'quantity' => fake()->numberBetween(1, 100),
        ];
    }
}
