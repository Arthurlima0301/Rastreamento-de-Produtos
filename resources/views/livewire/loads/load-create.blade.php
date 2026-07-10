<div class="w-full">
    <x-card title="Criar Carga">
        <x-slot name="slot">
            <div class="flex items-center space-x-4">
                <p class="font-bold">Material:</p>

                <x-select wire:model.live="materialId">
                    <option value="">Selecione um material</option>
                    @foreach ($materials as $material)
                        <option value="{{ $material->id }}">{{ $material->paper }} -
                            {{ $material->formatted_grammage }}
                            - {{ $material->roll }}</option>
                    @endforeach
                </x-select>
            </div>
        </x-slot>
    </x-card>

    <section class="flex space-x-4 ">

        <div>
            <x-search-input />
            <x-table :paginate="$rolls">
                <x-slot name="header">
                    <flux:table.column align="center">Rótulo</flux:table.column>
                    <flux:table.column align="center">Peso</flux:table.column>
                    <flux:table.column align="center">Nota Fiscal</flux:table.column>
                    <flux:table.column align="center">Material</flux:table.column>
                    <flux:table.column align="center">Gramatura</flux:table.column>
                    <flux:table.column align="center">Rolo</flux:table.column>
                    <flux:table.column align="center">Cód. Envio</flux:table.column>
                    <flux:table.column align="center">Cód. Expedição</flux:table.column>
                    <flux:table.column align="center">Lote de Retorno</flux:table.column>
                    <flux:table.column align="center">Ações</flux:table.column>
                </x-slot>
                <x-slot name="rows">
                    @foreach ($rolls as $roll)
                        <flux:table.row align="center">

                            <flux:table.cell>{{ $roll->label }}</flux:table.cell>
                            <flux:table.cell>{{ $roll->weight }}</flux:table.cell>
                            <flux:table.cell>{{ $roll->itemMaterial->materialInvoice->formatted_invoice_code }}</flux:table.cell>
                            <flux:table.cell align="center">{{ $roll->itemMaterial->material->paper }}</flux:table.cell>
                            <flux:table.cell align="center">{{ $roll->itemMaterial->material->formatted_grammage }}
                            </flux:table.cell>
                            <flux:table.cell align="center">{{ $roll->itemMaterial->material->roll }}</flux:table.cell>
                            <flux:table.cell align="center">{{ $roll->itemMaterial->material->shipment_code }}
                            </flux:table.cell>
                            <flux:table.cell align="center">{{ $roll->itemMaterial->material->expedition_code }}
                            </flux:table.cell>
                            <flux:table.cell align="center">{{ $roll->itemMaterial->material->return_batch }}
                            </flux:table.cell>

                            <flux:table.cell>
                                <x-button variant="ghost" icon="plus"
                                    wire:click="$dispatch('add-roll', 
                                        { rollId: {{ $roll->id }}, rollLabel: '{{ $roll->label }}', rollWeight: '{{ $roll->formatted_weight }}' })" />
                            </flux:table.cell>

                        </flux:table.row>
                    @endforeach
                </x-slot>
            </x-table>
        </div>

        <livewire:loads.selected-rolls-list />
    </section>

</div>
