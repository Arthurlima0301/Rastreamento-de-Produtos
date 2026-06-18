<?php

namespace App\Livewire\Materials;

use App\Models\Material;
use App\Models\Order;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Editar Material')]
class MaterialEdit extends Component
{
    public Material $material;

    public array $form = [
        'order_id' => '',
        'item_number' => '',
        'shipment_code' => '',
        'roll' => '',
        'width' => '',
        'length' => '',
        'sheets' => '',
        'grammage' => '',
        'expedition_code' => '',
        'paper' => '',
        'return_batch' => '',
        'packages' => '',
        'package_net_weight' => '',
        'package_gross_weight' => '',
    ];

    public function mount(Material $material)
    {
        $this->material = $material;

        $this->form = $material->only(array_keys($this->form));
    }

    public function render()
    {
        return view('livewire.materials.material-edit', [
            'orders' => Order::all(),
        ]);
    }

    public function saveEdit()
    {
        $validated = $this->validate();

        $materialExists = Material::query()
            ->where('order_id', $this->form['order_id'])
            ->where('shipment_code', $this->form['shipment_code'])
            ->where('id', '!=', $this->material->id)
            ->exists();

        if ($materialExists) {
            $this->addError('error', 'Esse material já existe com um Lote diferente na ordem selecionada.');

            return;
        }

        $this->material->update($validated['form']);

        return redirect()->route('orders.show', $this->form['order_id'])->with('success', 'Material Editado com sucesso!');
    }

    public function rules(): array
    {
        return [
            'form.order_id' => ['required', 'exists:orders,id'],
            'form.item_number' => ['required'],
            'form.shipment_code' => ['required'],
            'form.roll' => ['required'],
            'form.width' => ['required'],
            'form.length' => ['required'],
            'form.sheets' => ['required'],
            'form.grammage' => ['required', 'numeric'],
            'form.expedition_code' => ['required'],
            'form.paper' => ['required'],
            'form.return_batch' => ['required', Rule::unique('materials', 'return_batch')->ignore($this->material->id)],
            'form.packages' => ['required', 'integer'],
            'form.package_net_weight' => ['required', 'numeric'],
            'form.package_gross_weight' => ['required', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'form.order_id.required' => 'Selecione um pedido.',
            'form.order_id.exists' => 'O pedido selecionado não existe.',

            'form.item_number.required' => 'Informe o número do item.',
            'form.shipment_code.required' => 'Informe o código de envio.',
            'form.roll.required' => 'Informe o rolo.',
            'form.width.required' => 'Informe a largura.',
            'form.length.required' => 'Informe o comprimento.',
            'form.sheets.required' => 'Informe a quantidade de folhas.',
            'form.grammage.required' => 'Informe a gramatura.',
            'form.grammage.numeric' => 'A gramatura deve ser um número.',

            'form.expedition_code.required' => 'Informe o código de expedição.',
            'form.paper.required' => 'Informe o papel.',
            'form.return_batch.required' => 'Informe o lote de retorno.',
            'form.return_batch.unique' => 'O Lote de retorno já está em uso.',

            'form.packages.required' => 'Informe a quantidade de pacotes.',
            'form.packages.integer' => 'A quantidade de pacotes deve ser um número inteiro.',

            'form.package_net_weight.required' => 'Informe o peso líquido do pacote.',
            'form.package_net_weight.numeric' => 'O peso líquido do pacote deve ser um número.',

            'form.package_gross_weight.required' => 'Informe o peso bruto do pacote.',
            'form.package_gross_weight.numeric' => 'O peso bruto do pacote deve ser um número.',
        ];
    }
}
