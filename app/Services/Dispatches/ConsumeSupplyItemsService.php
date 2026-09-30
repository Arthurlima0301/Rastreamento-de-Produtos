<?php

namespace App\Services\Dispatches;

use App\Models\Dispatch;
use Illuminate\Support\Facades\DB;

class ConsumeSupplyItemsService
{
    /**
     * Consume a list of supply items and create a Dispatch record.
     */
    public function consume(array $supplyItems, Dispatch $dispatch): void
    {
        DB::transaction(function () use ($supplyItems, $dispatch) {
            $this->createDispatchRecord($supplyItems, $dispatch);
        });
    }

    /**
     * Create a Dispatch record with the provided supply items.
     */
    private function createDispatchRecord(array $supplyItems, Dispatch $dispatch): void
    {
        foreach ($supplyItems as $supplyItem) {
            $dispatch->dispatchItems()->create([
                'supply_item_id' => $supplyItem['id'],
                'quantity' => $supplyItem['quantity'],
            ]);
        }
    }
}
