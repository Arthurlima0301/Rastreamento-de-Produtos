<?php

namespace App\Livewire\Dispatches;

use App\Rules\Dispatches\ValidateConsumeItems;
use App\Services\Dispatches\ConsumeItemsService;
use Livewire\Attributes\On;
use Livewire\Component;

class SelectedItemsList extends Component
{
    public array $selectedItems = [];

    public function render()
    {
        return view('livewire.dispatches.selected-items-list');
    }

    /**
     * Add an item to the selected items list with its ID, supply name, and a null quantity for user input.
     */
    #[On('item-selected')]
    public function selectItem($itemId, $itemSupplyName)
    {
        $this->resetErrorBag();

        if (isset($this->selectedItems[$itemId])) {
            return;
        }

        $this->selectedItems[$itemId] = [
            'id' => $itemId,
            'supply_name' => $itemSupplyName,
            'quantity' => null,
        ];
    }

    /**
     * Remove an item from the selected items list based on its ID. If the item exists in the list, it will be removed.
     */
    public function removeItem($itemId)
    {
        $this->resetErrorBag();

        if (isset($this->selectedItems[$itemId])) {
            unset($this->selectedItems[$itemId]);

            $this->dispatch('item-removed', itemId: $itemId);

            return;
        }
    }

    /**
     * Clear the selected items list, removing all items from the selection.
     */
    public function clearSelection()
    {
        $this->resetErrorBag();

        foreach (array_keys($this->selectedItems) as $itemId) {
            $this->dispatch('item-removed', itemId: $itemId);
        }

        $this->selectedItems = [];
    }

    public function openModal($modalName)
    {
        $this->dispatch('open-modal', name: $modalName);
    }

    /**
     * Validate the selected items and their quantities before saving the dispatch.
     */
    public function save(ConsumeItemsService $consumeItemsService)
    {
        $this->validate([
            'selectedItems' => ['required', 'array', 'min:1', new ValidateConsumeItems],
            'selectedItems.*.quantity' => 'required|numeric|min:0.01',
        ], [
            'selectedItems.required' => 'Selecione pelo menos um item para criar a saída.',
            'selectedItems.*.quantity.required' => 'A quantidade é obrigatória para cada item selecionado.',
            'selectedItems.*.quantity.numeric' => 'A quantidade deve ser um número válido.',
            'selectedItems.*.quantity.min' => 'A quantidade deve ser pelo menos 0.01.',
        ]);

        try {
            $consumeItemsService->consume($this->selectedItems);

            return redirect()->route('dispatches.index')->with('success', 'Saída processada com sucesso!');
        } catch (\Exception $e) {
            $this->addError('selectedItems', 'Ocorreu um erro ao processar a saída: '.$e->getMessage());
        }
    }
}
