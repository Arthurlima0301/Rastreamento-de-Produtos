<div class="w-full">
    <x-card title="Detalhes da Ordem de Corte">
        <x-slot name="slot">
            <p><strong>Código:</strong> {{ $order->order_code }}</p>
            <p><strong>Cliente:</strong> {{ $order->client->name }}</p>
            <p><strong>Quantidade de Materiais:</strong> {{ $order->materials->count() }}</p>
            <x-button href="{{ route('materials.create', ['order' => $order->id]) }}" variant="primary" icon="plus">
                Adicionar Material
            </x-button>
        </x-slot>
    </x-card>

    <x-error-message />
    <x-success-message />

    <x-table>
        <x-slot:header>
            <flux:table.column align="center">Item</flux:table.column>
            <flux:table.column align="center">Cód. Envio</flux:table.column>
            <flux:table.column align="center">Rolo</flux:table.column>
            <flux:table.column align="center">Largura</flux:table.column>
            <flux:table.column align="center">Comprimento</flux:table.column>
            <flux:table.column align="center">Folhas</flux:table.column>
            <flux:table.column align="center">Gramatura</flux:table.column>
            <flux:table.column align="center">Cód. Expedição</flux:table.column>
            <flux:table.column align="center">Papel</flux:table.column>
            <flux:table.column align="center">Lote de Retorno</flux:table.column>
            <flux:table.column align="center">Pacotes</flux:table.column>
            <flux:table.column align="center">Peso Líquido P.</flux:table.column>
            <flux:table.column align="center">Peso Bruto P.</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($order->materials as $material)
                <flux:table.row wire:key="material-{{ $material->id }}">
                    <flux:table.cell align="center">{{ $material->item_number }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->shipment_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->roll }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->width }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->length }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->sheets }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->formatted_grammage }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->expedition_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->paper }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->return_batch }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->packages }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->formatted_package_net_weight }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->formatted_package_gross_weight }}</flux:table.cell>
                    <flux:table.cell align="center">
                        @if ($this->activeEdit === $material->id)
                            <x-button href="{{ route('materials.edit', $material->id) }}" variant="ghost" icon="tag" size="sm" />
                            <x-button wire:click="removeMaterial({{ $material->id }})" variant="primary" color="red"
                                icon="trash" size="sm" />
                            <x-button wire:click="cancelEdit()" variant="ghost" icon="x-mark" size="sm" />
                        @else
                            <x-button wire:click="editMaterial({{ $material->id }})" variant="ghost" icon="pencil"
                                size="sm" />
                        @endif
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
