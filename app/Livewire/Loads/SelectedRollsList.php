<?php

namespace App\Livewire\Loads;

use App\Models\Machine;
use App\Services\Loads\CreateLoadService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class SelectedRollsList extends Component
{
    public ?int $selectedMachineId = null;
    public ?string $selectedTurn = null;
    public ?string $selectedCuttedAt = null;
    public Collection $machines;

    public array $selectedRolls = [];

    public function mount()
    {
        $this->machines = Machine::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    /**
     * Render the component view for displaying the list of selected rolls.
     */
    public function render(): View
    {
        return view('livewire.loads.selected-rolls-list');
    }

    /**
     * Clear all selected rolls from the list.
     */
    #[On('clear-selection')]
    public function clearSelection()
    {
        $this->resetErrorBag();
        $this->selectedRolls = [];
    }

    /**
     * Remove a specific roll from the selectedRolls array based on its ID.
     */
    public function removeRoll($rollId)
    {
        $this->resetErrorBag();
        unset($this->selectedRolls[$rollId]);
    }

    /**
     * Listen for the 'add-roll' event and add the roll to the selectedRolls array if it's not already present.
     */
    #[On('add-roll')]
    public function addRoll($rollId, $rollLabel, $rollWeight)
    {
        if (count($this->selectedRolls) >= 6) {
            $this->addError('selectedRolls', 'O limite de 6 bobinas foi atingido.');

            return;
        }

        if (isset($this->selectedRolls[$rollId])) {
            $this->addError('selectedRolls', "A bobina $rollLabel já está selecionada");

            return;
        }

        $this->resetErrorBag();

        $this->selectedRolls[$rollId] = [
            'id' => $rollId,
            'label' => $rollLabel,
            'weight' => $rollWeight,
            'defect' => null,
            'defect_weight' => null,
        ];
    }

    /**
     * Save the selected rolls to the database, associating them with the selected machine and turn.
     */
    public function save(CreateLoadService $loadService)
    {
        $this->validate();

        try {
            $loadService->create($this->selectedMachineId, $this->selectedTurn, $this->selectedRolls, $this->selectedCuttedAt);

            return redirect()->route('loads.index')->with('success', 'Carga criada com sucesso!');

        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro ao criar a carga: '.$e->getMessage());
        }
    }

    /**
     * Define validation rules for the component properties to ensure that required fields are filled and valid before saving.
     */
    protected function rules(): array
    {
        return
            [
                'selectedMachineId' => 'required|exists:machines,id',
                'selectedTurn' => 'required|in:DIURNO,VESPERTINO,NOTURNO',
                'selectedCuttedAt' => 'required|date',
                'selectedRolls' => 'required|array|min:1|max:6',
                'selectedRolls.*.id' => 'required|exists:rolls,id',
                'selectedRolls.*.defect' => 'nullable|string|max:255',
                'selectedRolls.*.defect_weight' => 'nullable|integer|min:0',
            ];
    }

    /**
     * Messages for validation errors to provide user-friendly feedback when validation rules are not met.
     */
    protected function messages(): array
    {
        return [
            'selectedMachineId.required' => 'A máquina é obrigatória.',
            'selectedMachineId.exists' => 'A máquina selecionada é inválida.',
            'selectedTurn.required' => 'O turno é obrigatório.',
            'selectedTurn.in' => 'O turno selecionado é inválido.',
            'selectedCuttedAt.required' => 'A data de corte é obrigatória.',
            'selectedCuttedAt.date' => 'A data de corte é inválida.',
            'selectedRolls.min' => 'Selecione pelo menos uma bobina.',
            'selectedRolls.max' => 'O limite de 6 bobinas foi atingido.',
            'selectedRolls.*.id.exists' => 'Uma das bobinas selecionadas é inválida.',
            'selectedRolls.*.defect.string' => 'O campo "Defeito" deve ser uma string.',
            'selectedRolls.*.defect.max' => 'O campo "Defeito" deve ter no máximo 255 caracteres.',
            'selectedRolls.*.defect_weight.integer' => 'O campo "Peso do Defeito" deve ser um número inteiro.',
            'selectedRolls.*.defect_weight.min' => 'O campo "Peso do Defeito" deve ser um número positivo.',
        ];
    }
}
