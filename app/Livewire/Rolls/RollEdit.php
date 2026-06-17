<?php

namespace App\Livewire\Rolls;

use App\Models\Roll;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Editar Bobina')]
class RollEdit extends Component
{
    public Roll $roll;

    public string $rollWeight = '';

    public string $rollLabel = '';

    public string $roll_defect;

    public int $roll_defect_weight;

    /**
     * Mount the component with the roll data.
     */
    public function mount(Roll $roll): void
    {
        $this->roll = $roll->load('itemMaterial.materialInvoice', 'itemMaterial.material');

        $this->rollLabel = $roll->label;
        $this->roll_defect = (string) $roll->defect;
        $this->roll_defect_weight = (int) $roll->defect_weight;
        $this->rollWeight = (string) (int) $roll->weight;
    }

    /**
     * Render the roll edit page.
     */
    public function render(): View
    {
        return view('livewire.rolls.roll-edit');
    }

    /**
     * Validate and save the roll.
     */
    public function save()
    {

        $this->validate();

        $this->roll->update([
            'label' => $this->rollLabel,
            'weight' => $this->rollWeight,
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
    public function rules(): array
    {
        return [
            'rollLabel' => ['required', 'string', 'min:14', 'max:14', Rule::unique('rolls', 'label')->ignore($this->roll->id)],
            'rollWeight' => 'required|integer|min:100|max:5000',
            'roll_defect' => 'nullable|string|max:255',
            'roll_defect_weight' => 'nullable|integer|min:0|max:5000',
        ];
    }

    /**
     * Get the validation error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'rollLabel.required' => 'O campo "Rótulo" é obrigatório.',
            'rollLabel.min' => 'O campo "Rótulo" deve ter no mínimo 14 caracteres.',
            'rollLabel.max' => 'O campo "Rótulo" deve ter no máximo 14 caracteres.',
            'rollLabel.unique' => 'O Rótulo já foi cadastrado.',
            'rollWeight.required' => 'O campo "Peso" é obrigatório.',
            'rollWeight.integer' => 'O campo "Peso" deve ser um número inteiro.',
            'rollWeight.min' => 'O campo "Peso" deve ser no mínimo 100.',
            'rollWeight.max' => 'O campo "Peso" deve ser no máximo 5000.',
            'roll_defect_weight.integer' => 'O campo "Peso do Defeito" deve ser um número inteiro.',
            'roll_defect_weight.min' => 'O campo "Peso do Defeito" deve ser no mínimo 0.',
            'roll_defect_weight.max' => 'O campo "Peso do Defeito" deve ser no máximo 5000.',
        ];
    }
}
