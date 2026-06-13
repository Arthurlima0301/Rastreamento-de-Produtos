<?php

namespace App\Livewire\Supplies;

use App\Models\Client;
use App\Models\Supply;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SupplyForm extends Component
{
    public ?int $supplyId = null;

    public string $supply_code = '';

    public string $name = '';

    public string $unit_of_measure = '';

    public ?int $client_id = null;

    /**
     * Load the supply data when editing.
     */
    public function mount(?int $supplyId = null): void
    {
        $this->supplyId = $supplyId;

        if ($this->supplyId) {
            $supply = Supply::findOrFail($this->supplyId);
            $this->supply_code = $supply->supply_code;
            $this->name = $supply->name;
            $this->unit_of_measure = $supply->unit_of_measure;
            $this->client_id = $supply->client_id;
        }
    }

    /**
     * Validate and save the supply.
     */
    public function save()
    {
        $validated = $this->validate([
            'supply_code' => ['required', 'string', Rule::unique('supplies', 'supply_code')->ignore($this->supplyId)],
            'name' => 'required|string',
            'unit_of_measure' => 'required|string',
            'client_id' => 'required|exists:clients,id',
        ], [
            'supply_code.required' => 'O campo "Código do Insumo" é obrigatório.',
            'supply_code.unique' => 'O código do insumo já existe. Por favor, escolha outro.',
            'name.required' => 'O campo "Nome" é obrigatório.',
            'unit_of_measure.required' => 'O campo "Unidade de Medida" é obrigatório.',
            'unit_of_measure.string' => 'O campo "Unidade de Medida" deve ser um texto.',
            'client_id.required' => 'O campo "Cliente" é obrigatório.',
            'client_id.exists' => 'O cliente informado é inválido.',
        ]);

        if ($this->supplyId) {
            Supply::findOrFail($this->supplyId)->update($validated);

            return redirect()->route('supplies.index')->with('success', 'Insumo atualizado com sucesso!');
        }

        Supply::create($validated);

        return redirect()->route('supplies.index')->with('success', 'Insumo criado com sucesso!');
    }

    /**
     * Render the supply form.
     */
    public function render()
    {
        $clients = Client::orderBy('name', 'asc')->get();

        return view('livewire.supplies.supply-form', compact('clients'));
    }
}
