<?php

namespace Database\Factories;

use App\Models\Material;
use App\Models\MaterialInvoice;
use App\Models\MaterialItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MaterialItem>
 */
class MaterialItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'material_id' => Material::factory(),
            'material_invoice_id' => MaterialInvoice::factory(),
            'roll_quantity' => fake()->randomFloat(2, 1, 9999999999.99),
            'weight' => fake()->randomFloat(2, 1, 9999999999.99),
        ];
    }
}
