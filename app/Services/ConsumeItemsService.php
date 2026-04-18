<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Saida;
use Illuminate\Support\Facades\DB;

class ConsumeItemsService
{
    /**
     * Consume a list of items and create a Saida record
     */
    public function consume(array $items)
    {
        DB::transaction(function () use ($items) {
            $this->verifyItemsBalance($items);
            $this->createSaidaRecord($items);
        });
    }


    /**
     * Verify if each item has sufficient balance for the requested quantity
     */
    private function verifyItemsBalance(array $items)
    {
        foreach ($items as $item) {
            $itemModel = Item::withSum('saidasItems', 'quantidade')->where('id', $item['id'])->lockForUpdate()->first();

            if ($itemModel->saldo < (float) $item['quantidade'] || $itemModel->saldo <= 0) {
                throw new \Exception("O item {$itemModel->nome} não possui saldo suficiente para a saída.");
            }
        }
    }

    /**
     * Create a Saida record with the provided items
     */
    private function createSaidaRecord(array $items)
    {
        $saida = Saida::create([
            'data_saida' => now(),
        ]);

        foreach ($items as $item) {
            $saida->items()->create([
                'item_id' => $item['id'],
                'quantidade' => $item['quantidade'],
            ]);
        }
    }
}
