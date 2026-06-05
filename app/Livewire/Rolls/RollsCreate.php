<?php

namespace App\Livewire\Rolls;

use App\Models\ItemMaterial;
use App\Models\Roll;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


#[Layout('Layout.layout')]
#[Title('Adicionar Bobina')]
class RollsCreate extends Component
{
    public ItemMaterial $itemMaterial;
    public string $roll_label = '';
    public int $roll_weight;

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
        $this->validate([
            'roll_label' => 'required|string|min:14|max:14|unique:rolls,label',
            'roll_weight' => 'required|integer|min:100|max:5000',
        ],[
            'roll_label.required' => 'O campo "Código" é obrigatório.',
            'roll_label.min' => 'O campo "Código" deve ter no mínimo 14 caracteres.',
            'roll_label.max' => 'O campo "Código" deve ter no máximo 14 caracteres.',
            'roll_label.unique' => 'O código da bobina já está em uso.',
            'roll_weight.required' => 'O campo "Peso" é obrigatório.',
            'roll_weight.integer' => 'O campo "Peso" deve ser um número inteiro.',
            'roll_weight.min' => 'O campo "Peso" deve ser no mínimo 100.',
            'roll_weight.max' => 'O campo "Peso" deve ser no máximo 5000.',
        ]);

        Roll::create([
            'item_material_id' => $this->itemMaterial->id,
            'label' => $this->roll_label,
            'weight' => $this->roll_weight,
            'status' => 'EM_ESTOQUE',
        ]);

        session()->flash('success', 'Bobina criada com sucesso!');
        $this->reset(['roll_label', 'roll_weight']);
    }    
}
