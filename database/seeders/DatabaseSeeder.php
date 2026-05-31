<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $order = Order::factory()->create();

        Material::factory()->count(10)->create([
            'order_id' => $order->id,
        ]);
    }
}
