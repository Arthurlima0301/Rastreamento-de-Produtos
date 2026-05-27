<?php

namespace App\Rules\Dispatches;

use App\Models\Item;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidateConsumeItems implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /**
         * Verify if each item has sufficient balance for the requested quantity.
         */
        foreach ($value as $item) {
            $itemModel = Item::withBalance()
                ->lockForUpdate()
                ->find($item['id']);

            if (! $itemModel) {
                $fail("O item com ID {$item['id']} não foi encontrado.");

                continue;
            }

            if ((float) $itemModel->balance < (float) $item['quantity'] || (float) $itemModel->balance <= 0) {
                $fail("O item {$itemModel->supply->name} não possui saldo suficiente para a saída.");
            }
        }
    }
}
