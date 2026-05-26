<?php

namespace Database\Factories;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Machine>
 */
class MachineFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word().' '.fake()->numberBetween(1, 99),
            'acronym' => strtoupper(fake()->lexify('?')),
        ];
    }
}
