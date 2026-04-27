<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'invoice_code' => fake()->unique()->numerify('######'),
            'issued_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
