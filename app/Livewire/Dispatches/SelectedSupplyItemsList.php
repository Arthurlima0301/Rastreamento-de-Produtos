<?php

namespace App\Livewire\Dispatches;

use App\Rules\Dispatches\ValidateConsumeSupplyItems;
use App\Services\Dispatches\ConsumeSupplyItemsService;
use Livewire\Attributes\On;
use Livewire\Component;

class SelectedSupplyItemsList extends Component
{
    public array $selectedSupplyItems = [];

    public function render()
    {
        return view('livewire.dispatches.selected-supply-items-list');
    }

    /**
     * Add a supply item to the selected supply items list with its ID, supply name, and a null quantity for user input.
     */
    #[On('supply-item-selected')]
    public function selectSupplyItem($supplyItemId, $supplyName)
    {
        $this->resetErrorBag();

        if (isset($this->selectedSupplyItems[$supplyItemId])) {
            return;
        }

        $this->selectedSupplyItems[$supplyItemId] = [
            'id' => $supplyItemId,
            'supply_name' => $supplyName,
            'quantity' => null,
        ];
    }

    /**
     * Remove a supply item from the selected supply items list based on its ID. If it exists in the list, it will be removed.
     */
    public function removeSupplyItem($supplyItemId)
    {
        $this->resetErrorBag();

        if (isset($this->selectedSupplyItems[$supplyItemId])) {
            unset($this->selectedSupplyItems[$supplyItemId]);

            $this->dispatch('supply-item-removed', supplyItemId: $supplyItemId);

            return;
        }
    }

    /**
     * Clear the selected supply items list, removing all items from the selection.
     */
    public function clearSelection()
    {
        $this->resetErrorBag();

        foreach (array_keys($this->selectedSupplyItems) as $supplyItemId) {
            $this->dispatch('supply-item-removed', supplyItemId: $supplyItemId);
        }

        $this->selectedSupplyItems = [];
    }

    public function openModal($modalName)
    {
        $this->dispatch('open-modal', name: $modalName);
    }

    /**
     * Validate the selected supply items and their quantities before saving the dispatch.
     */
    public function save(ConsumeSupplyItemsService $consumeItemsService)
    {
        $this->validate([
            'selectedSupplyItems' => ['required', 'array', 'min:1', new ValidateConsumeSupplyItems],
            'selectedSupplyItems.*.quantity' => 'required|numeric|min:0.01',
        ], [
            'selectedSupplyItems.required' => 'Selecione pelo menos um item para criar a saída.',
            'selectedSupplyItems.*.quantity.required' => 'A quantidade é obrigatória para cada item selecionado.',
            'selectedSupplyItems.*.quantity.numeric' => 'A quantidade deve ser um número válido.',
            'selectedSupplyItems.*.quantity.min' => 'A quantidade deve ser pelo menos 0.01.',
        ]);

        try {
            $consumeItemsService->consume($this->selectedSupplyItems);

            return redirect()->route('dispatches.index')->with('success', 'Saída processada com sucesso!');
        } catch (\Exception $e) {
            $this->addError('selectedSupplyItems', 'Ocorreu um erro ao processar a saída: '.$e->getMessage());
        }
    }
}
