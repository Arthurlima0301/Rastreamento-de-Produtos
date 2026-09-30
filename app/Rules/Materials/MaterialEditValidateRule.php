<?php

namespace App\Rules\Materials;

use App\Models\Material;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class MaterialEditValidateRule implements ValidationRule
{
    /*
        * Create a new rule instance.
        */
    public function __construct(
        private int $materialId
    ){}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the material has item materials with pallets associated
        $material = Material::find($this->materialId);

        if ($material && $material->itemMaterials()->whereHas('pallets')->exists()) {
            $fail('Não é possível editar este material, pois ele possui itens com paletes associados.');
            return;
        }

        // Check if a material with the same order_id and shipment_code exists, excluding the current material being edited
        $materialExists = Material::query()
            ->where('order_id', $value['order_id'])
            ->where('shipment_code', $value['shipment_code'])
            ->where('id', '!=', $this->materialId)
            ->exists();

        if ($materialExists) {
            $fail('Esse material já existe com um Lote diferente na ordem selecionada.');
            return;
        }
    }
}
