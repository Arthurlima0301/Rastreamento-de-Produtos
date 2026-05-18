<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Supply;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Supply>
 */
class SupplyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'supply_code' => fake()->unique()->numerify('SUP-#####'),
            'name' => fake()->words(3, true),
            'unit_of_measure' => fake()->randomElement(['kg', 'un', 'pc', 'm']),
            'client_id' => Client::factory(),
        ];
    }
}
