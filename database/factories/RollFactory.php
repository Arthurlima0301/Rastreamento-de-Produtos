<?php

namespace Database\Factories;

use App\Models\ItemMaterial;
use App\Models\Roll;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Roll>
 */
class RollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'weight' => $this->faker->randomFloat(2, 0, 100),
            'status' => $this->faker->randomElement(['EM_ESTOQUE', 'CORTADA']),
            'item_material_id' => ItemMaterial::factory(),
        ];
    }
}
