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
    public string $roll_defect;
    public int $roll_defect_weight;

    public function mount(Roll $roll): void
    {
        $this->roll = $roll->load('itemMaterial.materialInvoice', 'itemMaterial.material');

        $this->roll_label = $roll->label;
        $this->roll_defect = (string) $roll->defect;
        $this->roll_defect_weight = (int) $roll->defect_weight;
        $this->roll_weight = (string) (int) $roll->weight;
    }

    public function render()
    {
        return view('livewire.rolls.roll-edit');
    }

    public function save()
    {

        $this->validate();

        $this->roll->update([
            'label' => $this->roll_label,
            'weight' => $this->roll_weight,
            'defect' => $this->roll_defect == '' ? null : $this->roll_defect,
            'defect_weight' => $this->roll_defect_weight ?? null,
        ]);

        return redirect()
            ->route('item-materials.show', $this->roll->item_material_id)
            ->with('success', 'Bobina atualizada com sucesso!');
    }

    /**
     *  Get the validation rules that apply to the component's properties.
     */
    public function rules()
    {
        return [
            'roll_label' => ['required', 'string', 'min:14', 'max:14', Rule::unique('rolls', 'label')->ignore($this->roll->id)],
            'roll_weight' => 'required|integer|min:100|max:5000',
            'roll_defect' => 'nullable|string|max:255',
            'roll_defect_weight' => 'nullable|integer|min:0|max:5000',
        ];
    }

    /**
     * Get the validation error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'roll_label.required' => 'O campo "Rótulo" é obrigatório.',
            'roll_label.min' => 'O campo "Rótulo" deve ter no mínimo 14 caracteres.',
            'roll_label.max' => 'O campo "Rótulo" deve ter no máximo 14 caracteres.',
            'roll_label.unique' => 'O Rótulo já foi cadastrado.',
            'roll_weight.required' => 'O campo "Peso" é obrigatório.',
            'roll_weight.integer' => 'O campo "Peso" deve ser um número inteiro.',
            'roll_weight.min' => 'O campo "Peso" deve ser no mínimo 100.',
            'roll_weight.max' => 'O campo "Peso" deve ser no máximo 5000.',
            'roll_defect_weight.integer' => 'O campo "Peso do Defeito" deve ser um número inteiro.',
            'roll_defect_weight.min' => 'O campo "Peso do Defeito" deve ser no mínimo 0.',
            'roll_defect_weight.max' => 'O campo "Peso do Defeito" deve ser no máximo 5000.',
        ];
    }
}
