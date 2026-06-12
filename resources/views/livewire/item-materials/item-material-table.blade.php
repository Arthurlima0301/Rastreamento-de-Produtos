<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$itemMaterials">
        <x-slot name="header">
            <flux:table.column align="center">Nº do Item</flux:table.column>
            <flux:table.column align="center">Nota Fiscal</flux:table.column>
            <flux:table.column align="center">Data</flux:table.column>
            <flux:table.column align="center">Papel</flux:table.column>
            <flux:table.column align="center">Gramatura</flux:table.column>
            <flux:table.column align="center">Cód. Expedição</flux:table.column>
            <flux:table.column align="center">Lote de Retorno</flux:table.column>
            <flux:table.column align="center">Item</flux:table.column>
            <flux:table.column align="center">Pedido</flux:table.column>
            <flux:table.column align="center">Rolo</flux:table.column>
            <flux:table.column align="center">Largura</flux:table.column>
            <flux:table.column align="center">Comprimento</flux:table.column>
            <flux:table.column align="center">Pacotes</flux:table.column>
            <flux:table.column align="center">Peso</flux:table.column>
        </x-slot:header>

        <x-slot name="rows">
            @foreach ($itemMaterials as $itemMaterial)
                <flux:table.row wire:key="item-material-{{ $itemMaterial->id }}">
                    <flux:table.cell align="center">{{ $itemMaterial->number }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <a href="{{ route('material-invoices.show', $itemMaterial->materialInvoice->id) }}"
                            class="hover:underline">
                            {{ $itemMaterial->materialInvoice->formatted_invoice_code }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->materialInvoice->formatted_issued_at }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <a href="{{ route('item-materials.show', $itemMaterial) }}" class="hover:underline">
                            {{ $itemMaterial->material->paper }}
                        </a>
                    </flux:table.cell>
                    
                    <flux:table.cell align="center">{{ $itemMaterial->material->formatted_grammage }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->expedition_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->return_batch }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->item_number }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->order->order_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->roll }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->width }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->length }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->packages }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->formatted_total_weight }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot>
    </x-table>
</div>
