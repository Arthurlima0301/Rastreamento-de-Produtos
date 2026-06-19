<?php

namespace App\Livewire\Loads;

use App\Models\Load;
use App\Models\Machine;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class EditLoad extends Component
{
    public Load $load;

    public array $form = [
        'cutted_at' => '',
        'turn' => '',
        'machine_id' => '',
    ];

    public bool $isEditing = false;

    /**
     * Load the current load data into the edit form.
     */
    public function mount(Load $load): void
    {
        $this->load = $load->load('machine');

        $this->form = [
            'cutted_at' => $this->load->cutted_at?->format('Y-m-d') ?? '',
            'turn' => $this->load->turn ?? '',
            'machine_id' => $this->load->machine_id ?? '',
        ];
    }

    /**
     * Render the load edit component.
     */
    public function render(): View
    {
        $machines = Machine::query()->orderBy('name')->get();

        return view('livewire.loads.edit-load', compact('machines'));
    }

    /**
     * Enable load editing.
     */
    public function edit(): void
    {
        $this->isEditing = true;
    }

    /**
     * Cancel editing and restore the persisted load data.
     */
    public function cancelEdit(): void
    {
        $this->isEditing = false;

        $this->form = [
            'cutted_at' => $this->load->cutted_at?->format('Y-m-d') ?? '',
            'turn' => $this->load->turn ?? '',
            'machine_id' => $this->load->machine_id ?? '',
        ];
    }

    /**
     * Validate and save load changes.
     */
    public function save(): void
    {
        $validated = $this->validate(
            [
                'form.cutted_at' => ['required', 'date'],
                'form.turn' => ['required', 'in:DIURNO,VESPERTINO,NOTURNO'],
                'form.machine_id' => ['required', 'exists:machines,id'],
            ],
            [
                'form.cutted_at.required' => 'Insira a data de corte.',
                'form.cutted_at.date' => 'A data deve ser uma data válida.',
                'form.turn.required' => 'Escolha um turno.',
                'form.machine_id.required' => 'Escolha uma máquina.',
            ]
        );

        $this->load->update($validated['form']);
        $this->isEditing = false;

        session()->flash('success', 'Informações da carga atualizadas com sucesso!');
    }
}
