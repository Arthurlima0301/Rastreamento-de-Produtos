<?php

namespace App\Livewire\Rolls;

use App\Models\ItemMaterial;
use App\Models\Roll;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Adicionar Bobinas')]
class RollsCreate extends Component
{
    public ItemMaterial $itemMaterial;

    public string $roll_batch;

    public string $roll_vol;

    public int $roll_weight;

    public string $roll_label = '000000000-0000';

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
    public function render()
    {
        return view('livewire.rolls.rolls-create');
    }

    /**
     * Handle the creation of rolls for the item material.
     */
    public function save()
    {
        $this->roll_label = "$this->roll_batch-$this->roll_vol";

        $this->validate([
            'roll_batch' => 'required|string|min:9|max:9',
            'roll_label' => 'unique:rolls,label',
            'roll_vol' => 'required|string|min:4|max:4',
            'roll_weight' => 'required|integer|min:100|max:5000',
        ], [
            'roll_batch.required' => 'O campo "Lote" é obrigatório.',
            'roll_batch.min' => 'O campo "Lote" deve ter no mínimo 9 caracteres.',
            'roll_batch.max' => 'O campo "Lote" deve ter no máximo 9 caracteres.',
            'roll_label.unique' => 'O Rótulo já foi cadastrado.',
            'roll_vol.required' => 'O campo "Volume" é obrigatório.',
            'roll_vol.min' => 'O campo "Volume" deve ter no mínimo 4 caracteres.',
            'roll_vol.max' => 'O campo "Volume" deve ter no máximo 4 caracteres.',
            'roll_weight.required' => 'O campo "Peso" é obrigatório.',
            'roll_weight.integer' => 'O campo "Peso" deve ser um número inteiro.',
            'roll_weight.min' => 'O campo "Peso" deve ser no mínimo 100.',
            'roll_weight.max' => 'O campo "Peso" deve ser no máximo 5000.',
        ]);

        Roll::create([
            'item_material_id' => $this->itemMaterial->id,
            'label' => "$this->roll_batch-$this->roll_vol",
            'weight' => $this->roll_weight,
            'status' => 'EM_ESTOQUE',
        ]);

        session()->flash('success', "Bobina  $this->roll_batch-$this->roll_vol criada com sucesso!");
        $this->reset(['roll_vol', 'roll_weight']);
        $this->dispatch('focus-roll-vol');
    }
}
