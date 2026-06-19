<div class="w-full">
    <x-card title="Adicionar Bobinas à Carga">
        <x-slot name="slot">
            <p><strong>Código: </strong>{{ $load->machine->abbreviation }}-{{ $load->id }}</p>
            <p><strong>Data de Corte: </strong> {{ $load->formatted_cutted_at }}</p>
            <p><strong>Turno: </strong> {{ $load->turn }}</p>
            <p><strong>Máquina: </strong> {{ $load->machine->name }}</p>
        </x-slot>
    </x-card>

    <x-success-message />
    <x-error-message />

    <x-search-input />
    <x-table :paginate="$rolls">
        <x-slot name="header">
            <flux:table.column align="center">Rótulo</flux:table.column>
            <flux:table.column align="center">Peso</flux:table.column>
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
                <flux:table.row align="center" wire:key="load-roll-{{ $roll->id }}">

                    <flux:table.cell>{{ $roll->label }}</flux:table.cell>
                    <flux:table.cell>{{ $roll->weight }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->paper }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->formatted_grammage }}
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->roll }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->shipment_code }}
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->expedition_code }}
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->return_batch }}</flux:table.cell>

                    <flux:table.cell>
                        @if ($roll->load_id === $load->id)
                            <p class="text-zinc-500">Já adicionada</p>
                        @else
                            <x-button variant="ghost" icon="plus" size="sm"
                                wire:click='addRoll({{ $roll->id }})' />
                        @endif
                    </flux:table.cell>

                </flux:table.row>
            @endforeach
        </x-slot>
    </x-table>
</div>
