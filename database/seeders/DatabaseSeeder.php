<?php

namespace Database\Seeders;

use App\Models\ItemMaterial;
use App\Models\Roll;
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

        $itemMaterial = ItemMaterial::factory()->create();

        Roll::factory(50)->create([
            'item_material_id' => $itemMaterial->id,
        ]);
    }
}
