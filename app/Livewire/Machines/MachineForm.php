<?php

namespace App\Livewire\Machines;

use App\Models\Machine;
use Illuminate\Validation\Rule;
use Livewire\Component;

class MachineForm extends Component
{
    public ?int $machineId = null;

    public string $name = '';

    public string $abbreviation = '';

    public function mount(?int $machineId = null): void
    {
        $this->machineId = $machineId;

        if ($this->machineId) {
            $machine = Machine::findOrFail($this->machineId);
            $this->name = $machine->name;
            $this->abbreviation = $machine->abbreviation;
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:100',
            'abbreviation' => ['required', 'string', 'size:1', Rule::unique('machines', 'abbreviation')->ignore($this->machineId)],
        ], [
            'name.required' => 'O campo "Nome" é obrigatório.',
            'name.max' => 'O campo "Nome" deve ter no máximo 100 caracteres.',
            'abbreviation.required' => 'O campo "Sigla" é obrigatório.',
            'abbreviation.size' => 'O campo "Sigla" deve ter exatamente 1 caractere.',
            'abbreviation.unique' => 'A sigla já existe. Por favor, escolha outra.',
        ]);

        if ($this->machineId) {
            Machine::findOrFail($this->machineId)->update($validated);

            return redirect()->route('machines.index')->with('success', 'Máquina atualizada com sucesso!');
        }

        Machine::create($validated);

        return redirect()->route('machines.index')->with('success', 'Máquina criada com sucesso!');
    }

    public function render()
    {
        return view('livewire.machines.machine-form');
    }
}
