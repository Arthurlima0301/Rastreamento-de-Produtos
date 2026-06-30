<?php

namespace Database\Factories;

use App\Models\Pallet;
use App\Models\Load;
use App\Models\ItemMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

class PalletFactory extends Factory
{
    protected $model = Pallet::class;

    public function definition(): array
    {
        return [
            'label' => $this->faker->numberBetween(1000, 9999),
            'package_net_weight' => $this->faker->randomFloat(2, 0, 1000),
            'load_id' => Load::factory(),
            'item_material_id' => ItemMaterial::factory(),
        ];
    }
}