<?php

namespace App\Services;

use App\Models\Dispatch;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ConsumeItemsService
{
    /**
     * Consume a list of items and create a Dispatch record.
     */
    public function consume(array $items)
    {
        DB::transaction(function () use ($items) {
            $this->verifyItemsBalance($items);
            $this->createDispatchRecord($items);
        });
    }

    /**
     * Verify if each item has sufficient balance for the requested quantity.
     */
    private function verifyItemsBalance(array $items)
    {
        foreach ($items as $item) {
            $itemModel = Item::withSum('dispatchItems', 'quantity')->where('id', $item['id'])->lockForUpdate()->first();

            if ($itemModel->balance < (float) $item['quantity'] || $itemModel->balance <= 0) {
                throw new \Exception("O item {$itemModel->supply->name} não possui saldo suficiente para a saída.");
            }
        }
    }

    /**
     * Create a Dispatch record with the provided items.
     */
    private function createDispatchRecord(array $items)
    {
        $dispatch = Dispatch::create([
            'dispatched_at' => now(),
        ]);

        foreach ($items as $item) {
            $dispatch->items()->create([
                'item_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);
        }
    }
}
