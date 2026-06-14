<?php

namespace App\Livewire\Materials;

use App\Models\Material;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layout.layout')]
#[Title('Criar Material')]
class MaterialCreate extends Component
{
    public Order $order;

    public int $inputMaterial = 1;

    public array $materials = [];

    /**
     * Give a Order instance when mount the component, so we can link the created materials to this order.
     */
    public function mount(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.materials.material-create');
    }

    /**
     * Add a new material input field to the form.
     */
    public function addMaterialInput(): void
    {
        $this->inputMaterial++;
    }

    /**
     * Remove a material input field from the form by its index.
     */
    public function removeMaterialInput(int $index): void
    {
        unset($this->materials[$index]);
        $this->materials = array_values($this->materials);
        $this->inputMaterial--;
    }

    /**
     * Clear all material input fields from the form.
     */
    public function clearMaterialInput(): void
    {
        $this->materials = [];
        $this->inputMaterial = 0;
    }

    /**
     * Validate the form data and save all materials to the database.
     */
    public function saveAll()
    {
        $this->validate();

        foreach ($this->materials as $material) {
            Material::create($material + ['order_id' => $this->order->id]);
        }

        return redirect()->route('orders.show', $this->order)->with('success', 'Materiais adicionados com sucesso!');
    }

    /**
     * Define validation rules for the materials form.
     */
    public function rules(): array
    {
        return [
            'materials' => 'required|array|min:1',
            'materials.*.item_number' => 'required|string',
            'materials.*.shipment_code' => 'required|string',
            'materials.*.roll' => 'required|integer',
            'materials.*.width' => 'required|numeric',
            'materials.*.length' => 'required|numeric',
            'materials.*.sheets' => 'required|integer',
            'materials.*.grammage' => 'required|numeric|max:999.99',
            'materials.*.expedition_code' => 'required|string',
            'materials.*.paper' => 'required|string',
            'materials.*.return_batch' => 'required|string|unique:materials,return_batch',
            'materials.*.packages' => 'required|integer',
            'materials.*.package_net_weight' => 'required|numeric',
            'materials.*.package_gross_weight' => 'required|numeric',
        ];
    }

    /**
     * Define custom validation messages for the materials form.
     */
    public function messages(): array
    {
        return [
            'materials.required' => 'Adicione pelo menos um material.',
            'materials.*.item_number.required' => 'O campo "Número do Item" é obrigatório.',
            'materials.*.shipment_code.required' => 'O campo "Código de Envio" é obrigatório.',
            'materials.*.shipment_code.unique' => 'O Código de envio já existe.',
            'materials.*.roll.required' => 'O campo "Rolo" é obrigatório.',
            'materials.*.width.required' => 'O campo "Largura" é obrigatório.',
            'materials.*.length.required' => 'O campo "Comprimento" é obrigatório.',
            'materials.*.sheets.required' => 'O campo "Folhas" é obrigatório.',
            'materials.*.grammage.required' => 'O campo "Gramatura" é obrigatório.',
            'materials.*.grammage.max' => 'O campo "Gramatura" não pode ser maior que 999.99.',
            'materials.*.expedition_code.required' => 'O campo "Código de Expedição" é obrigatório.',
            'materials.*.expedition_code.unique' => 'O código de expedição já existe.',
            'materials.*.paper.required' => 'O campo "Papel" é obrigatório.',
            'materials.*.return_batch.required' => 'O campo "Lote de Retorno" é obrigatório.',
            'materials.*.return_batch.unique' => 'O campo "Lote de Retorno" já existe.',
            'materials.*.packages.required' => 'O campo "Pacotes" é obrigatório.',
            'materials.*.package_net_weight.required' => 'O campo "Peso Líquido do Pacote" é obrigatório.',
            'materials.*.package_gross_weight.required' => 'O campo "Peso Bruto do Pacote" é obrigatório.',
        ];
    }
}
