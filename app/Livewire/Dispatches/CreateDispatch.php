<?php

namespace App\Livewire\Dispatches;

use App\Models\Item;
use App\Rules\Dispatches\ValidateConsumeItems;
use App\Services\Dispatches\ConsumeItemsService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('Layout.layout')]
class CreateDispatch extends Component
{
    use WithPagination;

    public string $search = '';

    public array $selectedItems = [];

    /**
     * Render the component view with paginated items filtered by search term and balance.
     */
    public function render()
    {

        $items = Item::withBalance()
            ->filterBalance()
            ->searchBySupplyName($this->search)
            ->paginate(50);

        return view('livewire.dispatches.create-dispatch', compact('items'));
    }

    /**
     * Add an item to the selected items list with its ID, supply name, and a null quantity for user input.
     */
    public function selectItem($itemId, $itemSupplyName)
    {
        $this->resetErrorBag();

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

            return;
        }
    }

    /**
     * Clear the selected items list, removing all items from the selection.
     */
    public function clearSelection()
    {
        $this->resetErrorBag();
        $this->selectedItems = [];
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

            return redirect()->route('dispatches.index')->with('success','Saída processada com sucesso!');

        } catch (\Exception $e) {

            $this->addError('selectedItems', 'Ocorreu um erro ao processar a saída: ' . $e->getMessage());
        }
    }
}
