<?php

namespace App\Rules\Pallets;

use App\Models\ItemMaterial;
use App\Models\Load;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class GeneratePalletValidationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $itemMaterial = ItemMaterial::with('rolls', 'pallets', 'material')->find($value);
        
        if (!$itemMaterial) {
            $fail('Item material não encontrado.');
            return;
        }

        // Valid if item material pallets_quantity is defined and greater than 0
        if (!isset($itemMaterial->pallets_quantity) || $itemMaterial->pallets_quantity <= 0) {
            $fail('A quantidade de pallets deve ser definida.');
        }

        if (!Load::withSufficientBalance($itemMaterial->id, $itemMaterial->material->package_net_weight)->first()) {
            $fail('Não há carga com saldo suficiente para gerar os pallets.');
        }

        if($itemMaterial->pallets->count() >= $itemMaterial->pallets_quantity) {
            $fail('A quantidade máxima de pallets já foi atingida.');
        }

        if($itemMaterial->rolls->sum('weight') != $itemMaterial->total_weight) {
            $fail('O peso total somado das bobinas não corresponde ao peso total do item material.');
        }
    }
}
