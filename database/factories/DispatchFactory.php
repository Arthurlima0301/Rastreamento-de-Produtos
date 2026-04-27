<?php

namespace Database\Factories;

use App\Models\Dispatch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dispatch>
 */
class DispatchFactory extends Factory
{
    public function definition(): array
    {
        return [
            'invoice' => fake()->optional()->numerify('######'),
            'dispatched_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
