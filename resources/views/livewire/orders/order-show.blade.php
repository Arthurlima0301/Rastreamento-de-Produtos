<div class="w-full">
    <x-error-message />

    <x-card title="Detalhes da Ordem de Corte">
        <x-slot name="slot">
            <div class="flex items-center gap-4">
                <p><strong>Codigo:</strong> {{ $order->order_code }}</p>
                <p><strong>Cliente:</strong> {{ $order->client->name }}</p>
                <p><strong>Quantidade de Materiais:</strong> {{ $order->materials->count() }}</p>
                <x-button href="{{ route('materials.create', ['order' => $order->id]) }}" variant="primary" icon="plus" size="sm"></x-button>
            </div>
        </x-slot>
    </x-card>

    <x-success-message />

    <x-table>
        <x-slot:header>
            <flux:table.column align="center">Item</flux:table.column>
            <flux:table.column align="center">Cod. Envio</flux:table.column>
            <flux:table.column align="center">Rolo</flux:table.column>
            <flux:table.column align="center">Largura</flux:table.column>
            <flux:table.column align="center">Comprimento</flux:table.column>
            <flux:table.column align="center">Folhas</flux:table.column>
            <flux:table.column align="center">Gramatura</flux:table.column>
            <flux:table.column align="center">Cod. Expedicao</flux:table.column>
            <flux:table.column align="center">Papel</flux:table.column>
            <flux:table.column align="center">Lote Retorno</flux:table.column>
            <flux:table.column align="center">Pacotes</flux:table.column>
            <flux:table.column align="center">Peso Liq. P</flux:table.column>
            <flux:table.column align="center">Peso Bruto P</flux:table.column>
            <flux:table.column align="center">Acoes</flux:table.column>
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
                            <x-button wire:click="removeMaterial({{ $material->id }})" variant="ghost" icon="trash"
                                size="sm" />
                            <x-button wire:click="cancelEdit()" variant="ghost" icon="x-mark" size="sm" />
                        @else
                            <x-button wire:click="editMaterial({{ $material->id }})" variant="primary" icon="pencil"
                                size="sm" />
                        @endif
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
