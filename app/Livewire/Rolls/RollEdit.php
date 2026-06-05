<?php

namespace App\Livewire\Rolls;

use App\Models\Roll;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Editar Bobina')]
class RollEdit extends Component
{
    public Roll $roll;

    public string $roll_weight = '';

    public string $roll_label = '';

    public function mount(Roll $roll): void
    {
        $this->roll = $roll->load('itemMaterial.materialInvoice', 'itemMaterial.material');

        $this->roll_label = $roll->label;
        $this->roll_weight = (string) (int) $roll->weight;
    }

    public function save()
    {
        $this->validate([
            'roll_label' => ['required', 'string','min:14', 'max:14', Rule::unique('rolls', 'label')->ignore($this->roll->id)],
            'roll_weight' => 'required|integer|min:100|max:5000',
        ], [
            'roll_label.required' => 'O campo "Rótulo" é obrigatório.',
            'roll_label.min' => 'O campo "Rótulo" deve ter no mínimo 14 caracteres.',
            'roll_label.max' => 'O campo "Rótulo" deve ter no máximo 14 caracteres.',
            'roll_label.unique' => 'O Rótulo já foi cadastrado.',
            'roll_weight.required' => 'O campo "Peso" é obrigatório.',
            'roll_weight.integer' => 'O campo "Peso" deve ser um número inteiro.',
            'roll_weight.min' => 'O campo "Peso" deve ser no mínimo 100.',
            'roll_weight.max' => 'O campo "Peso" deve ser no máximo 5000.',
        ]);

        $this->roll->update([
            'label' => $this->roll_label,
            'weight' => $this->roll_weight,
        ]);

        return redirect()
            ->route('item-materials.show', $this->roll->item_material_id)
            ->with('success', 'Bobina atualizada com sucesso.');
    }

    public function render()
    {
        return view('livewire.rolls.roll-edit');
    }
}
