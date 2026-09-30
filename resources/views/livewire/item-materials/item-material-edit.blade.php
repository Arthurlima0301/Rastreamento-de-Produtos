<div class="w-full">
    <x-card title="Substituir Material do Item">
        <x-slot name="slot">
            <p><strong>Nota Fiscal:</strong> {{ $itemMaterial->materialInvoice->formatted_invoice_code }}</p>
            <p><strong>Item:</strong> {{ $itemMaterial->number }}</p>
        </x-slot>

    </x-card>

    <x-error-message />

    <x-search-input />

    <x-table :paginate="$materials">
        <x-slot name="header">
            <flux:table.column align="center">Papel</flux:table.column>
            <flux:table.column align="center">Gramatura</flux:table.column>
            <flux:table.column align="center">Cod. Expedicao</flux:table.column>
            <flux:table.column align="center">Lote Retorno</flux:table.column>
            <flux:table.column align="center">Item</flux:table.column>
            <flux:table.column align="center">Pedido</flux:table.column>
            <flux:table.column align="center">Rolo</flux:table.column>
            <flux:table.column align="center">Largura</flux:table.column>
            <flux:table.column align="center">Comprimento</flux:table.column>
            <flux:table.column align="center">Pacotes</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot name="rows">
            @foreach ($materials as $material)
                <flux:table.row wire:key="material-{{ $material->id }}">

                    <flux:table.cell align="center">{{ $material->paper }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->formatted_grammage }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->expedition_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->return_batch }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->item_number }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->order->order_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->roll }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->width }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->length }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->packages }}</flux:table.cell>
                    <flux:table.cell align="center">
                        @if ($material->id !== $itemMaterial->material_id)
                            <x-button wire:click="replaceMaterial({{ $material->id }})"
                                icon="arrow-path-rounded-square">
                                Substituir
                            </x-button>
                        @else
                            <span class="text-gray-500">Material Atual</span>
                        @endif
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot>
    </x-table>
</div>
