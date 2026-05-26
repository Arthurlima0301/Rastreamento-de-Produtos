<?php

namespace Database\Factories;

use App\Models\SupplyInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupplyInvoice>
 */
class SupplyInvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'supply_invoice_code' => fake()->unique()->numerify('######'),
            'issued_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
