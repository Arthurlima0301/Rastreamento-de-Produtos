<div class="w-full">
    <x-card title="Editar Pallet">
        <x-slot name="slot">
            <p><strong>NF: </strong> {{ $pallet->itemMaterial->materialInvoice->formatted_invoice_code }}</p>
            <p><strong>Item: </strong> {{ $pallet->itemMaterial->number }}</p>
            <p><strong>Papel: </strong> {{ $pallet->itemMaterial->material->paper }}</p>
            <p><strong>Gramatura: </strong> {{ $pallet->itemMaterial->material->formatted_grammage }}</p>
            <p><strong>Rolo: </strong> {{ $pallet->itemMaterial->material->roll }}</p>
        </x-slot>
    </x-card>

    <x-success-message />
    <x-error-message />

    <flux:card>
        <form wire:submit="save" class="flex flex-col gap-4 mt-4">
            <x-input label="Rótulo do Pallet" placeholder="Digite o rótulo do pallet" wire:model="palletLabel"
                maxlength="4" />


            <x-input label="Peso Líquido" value="{{ $pallet->formatted_package_net_weight }}" readonly />
            <x-input label="Carga Atual"
                value="{{ $pallet->cutLoad->machine->abbreviation . '-' . $pallet->cutLoad->id }}" readonly />



            <x-select label="Tranferir para Carga" wire:model="cutLoadId">
                <x-select.option value="{{ $pallet->cut_load_id }}">Nenhuma</x-select.option>
                @foreach ($loads as $load)
                    <x-select.option value="{{ $load->id }}">
                        {{ $load->machine->abbreviation . '-' . $load->id }}
                    </x-select.option>
                @endforeach
            </x-select>

            <x-button type="submit" variant="primary">Salvar</x-button>
        </form>
    </flux:card>
</div>
