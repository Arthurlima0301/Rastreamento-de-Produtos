<?php

namespace Database\Factories;

use App\Models\MaterialInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MaterialInvoice>
 */
class MaterialInvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'material_invoice_code' => fake()->unique()->numerify('######'),
        ];
    }
}
