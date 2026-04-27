<?php

namespace Database\Factories;

use App\Models\Dispatch;
use App\Models\DispatchItem;
use App\Models\Item;
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
            'item_id' => Item::factory(),
            'quantity' => fake()->numberBetween(1, 100),
        ];
    }
}
