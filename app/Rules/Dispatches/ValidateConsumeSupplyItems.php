<?php

namespace App\Rules\Dispatches;

use App\Models\SupplyItem;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidateConsumeSupplyItems implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /**
         * Verify if each supply item has sufficient balance for the requested quantity.
         */
        foreach ($value as $supplyItem) {
            $supplyItemModel = SupplyItem::withBalance()
                ->lockForUpdate()
                ->find($supplyItem['id']);

            if (! $supplyItemModel) {
                $fail("O item com ID {$supplyItem['id']} não foi encontrado.");

                continue;
            }

            if ((float) $supplyItemModel->balance < (float) $supplyItem['quantity'] || (float) $supplyItemModel->balance <= 0) {
                $fail("O item {$supplyItemModel->supply->name} não possui saldo suficiente para a saída.");
            }
        }
    }
}
