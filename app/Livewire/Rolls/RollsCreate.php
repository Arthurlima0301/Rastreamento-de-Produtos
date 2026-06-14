<?php

namespace App\Livewire\Rolls;

use App\Models\ItemMaterial;
use App\Models\Roll;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Adicionar Bobinas')]
class RollsCreate extends Component
{
    public ItemMaterial $itemMaterial;

    public string $rollBatch;

    public string $rollVolume;

    public int $rollWeight;

    public string $rollLabel = '000000000-0000';

    /**
     * Mount the item-material.
     */
    public function mount(ItemMaterial $itemMaterial)
    {
        $this->itemMaterial = $itemMaterial;
    }

    /**
     * Render the component view.
     */
    public function render(): View
    {
        return view('livewire.rolls.rolls-create');
    }

    /**
     * Handle the creation of rolls for the item material.
     */
    public function save()
    {
        $this->rollLabel = "$this->rollBatch-$this->rollVolume";

        $this->validate([
            'rollBatch' => 'required|string|min:9|max:9',
            'rollLabel' => 'unique:rolls,label',
            'rollVolume' => 'required|string|min:4|max:4',
            'rollWeight' => 'required|integer|min:100|max:5000',
        ], [
            'rollBatch.required' => 'O campo "Lote" é obrigatório.',
            'rollBatch.min' => 'O campo "Lote" deve ter no mínimo 9 caracteres.',
            'rollBatch.max' => 'O campo "Lote" deve ter no máximo 9 caracteres.',
            'rollLabel.unique' => 'O Rótulo já foi cadastrado.',
            'rollVolume.required' => 'O campo "Volume" é obrigatório.',
            'rollVolume.min' => 'O campo "Volume" deve ter no mínimo 4 caracteres.',
            'rollVolume.max' => 'O campo "Volume" deve ter no máximo 4 caracteres.',
            'rollWeight.required' => 'O campo "Peso" é obrigatório.',
            'rollWeight.integer' => 'O campo "Peso" deve ser um número inteiro.',
            'rollWeight.min' => 'O campo "Peso" deve ser no mínimo 100.',
            'rollWeight.max' => 'O campo "Peso" deve ser no máximo 5000.',
        ]);

        Roll::create([
            'item_material_id' => $this->itemMaterial->id,
            'label' => "$this->rollBatch-$this->rollVolume",
            'weight' => $this->rollWeight,
            'status' => 'EM_ESTOQUE',
        ]);

        session()->flash('success', "Bobina  $this->rollBatch-$this->rollVolume criada com sucesso!");
        $this->reset(['rollVolume', 'rollWeight']);
        $this->dispatch('focus-roll-vol');
    }
}
