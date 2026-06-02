<?php

namespace Database\Factories;

use App\Models\ItemMaterial;
use App\Models\Material;
use App\Models\MaterialInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemMaterial>
 */
class ItemMaterialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => fake()->numberBetween(1, 999),
            'material_id' => Material::factory(),
            'material_invoice_id' => MaterialInvoice::factory(),
        ];
    }
}
