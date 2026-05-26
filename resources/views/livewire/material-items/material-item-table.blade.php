<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$materialItems">
        <x-slot:header>
            <flux:table.column align="center">Nota Fiscal de Material</flux:table.column>
            <flux:table.column align="center">Pedido</flux:table.column>
            <flux:table.column align="center">Material</flux:table.column>
            <flux:table.column align="center">Codigo de Envio</flux:table.column>
            <flux:table.column align="center">Codigo de Expedicao</flux:table.column>
            <flux:table.column align="center">Quantidade de Bobinas</flux:table.column>
            <flux:table.column align="center">Peso</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($materialItems as $materialItem)
                <flux:table.row wire:key="material-item-{{ $materialItem->id }}">
                    <flux:table.cell align="center">{{ $materialItem->materialInvoice->formatted_material_invoice_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialItem->material->order->code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialItem->material->paper }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialItem->material->shipping_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialItem->material->expedition_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialItem->formatted_roll_quantity }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialItem->formatted_weight }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
