<?php

namespace App\Rules\Pallets;

use App\Models\Pallet;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ReplaceLabelValidate implements ValidationRule
{
    public function __construct(
        private int $palletId,
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $pallet = Pallet::with('cutLoad.machine', 'itemMaterial.material')->find($this->palletId);

        //
        if (!$pallet) {
            $fail('O pallet selecionado é inválido.');
        }

        // Test if the label is unique for the same material, excluding the current pallet
        $existingPallet = Pallet::query()
            ->where('label', '=', $value)
            ->where('id', '!=', $pallet->id)
            ->whereHas('itemMaterial', function ($query) use ($pallet) {
                $query->where('material_id', $pallet->itemMaterial->material->id);
            })
            ->exists();

        if ($existingPallet) {
            $fail('O novo rótulo enviado já está em uso para este material.');
        }
    }
}
