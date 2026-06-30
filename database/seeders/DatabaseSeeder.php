<?php

namespace Database\Seeders;

use App\Models\ItemMaterial;
use App\Models\Material;
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

        $material = Material::factory()->create([
            'paper' => 'Material Teste',
            'package_net_weight' => random_int(494, 525),
        ]);

        $itemMaterial1 = ItemMaterial::factory()->create([
            'total_weight' => random_int(15000, 20000),
            'material_id' => $material->id,
        ]);

        $itemMaterial2 = ItemMaterial::factory()->create([
            'total_weight' => random_int(15000, 20000),
            'material_id' => $material->id,
        ]);

        Roll::factory(23)->create([
            'weight' => random_int(1000, 1200),
            'item_material_id' => $itemMaterial1->id,
            'defect' => null,
            'defect_weight' => 0,
            'load_id' => null,
            'status' => 'EM_ESTOQUE',
        ]);

        Roll::factory(23)->create([
            'weight' => random_int(1000, 1200),
            'item_material_id' => $itemMaterial2->id,
            'defect' => null,
            'defect_weight' => 0,
            'load_id' => null,
            'status' => 'EM_ESTOQUE',
        ]);

    }
}
