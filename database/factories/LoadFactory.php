<?php

namespace Database\Factories;

use App\Models\Load;
use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Load>
 */
class LoadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->numberBetween(1, 100),
            'cutted_at' => $this->faker->date(),
            'turn' => $this->faker->randomElement(['DIURNO', 'VESPERTINO', 'NOTURNO']),
            'observation' => $this->faker->sentence(),
            'machine_id' => Machine::factory(),
        ];
    }
}
