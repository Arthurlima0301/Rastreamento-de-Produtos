<?php

namespace App\Rules\Dispatches;

use App\Models\SupplyItem;
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
        foreach ($value as $item) {
            $supplyItem = SupplyItem::withBalance()
                ->lockForUpdate()
                ->find($item['id']);

            if (! $supplyItem) {
                $fail("O item com ID {$item['id']} nao foi encontrado.");

                continue;
            }

            if ((float) $supplyItem->balance < (float) $item['quantity'] || (float) $supplyItem->balance <= 0) {
                $fail("O item {$supplyItem->supply->name} nao possui saldo suficiente para a saida.");
            }
        }
    }
}
