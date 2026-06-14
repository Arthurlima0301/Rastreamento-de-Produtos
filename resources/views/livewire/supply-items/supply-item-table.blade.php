<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$supplyItems">
        <x-slot:header>
            <flux:table.column align="center">Código</flux:table.column>
            <flux:table.column align="center">Insumo</flux:table.column>
            <flux:table.column align="center">Cliente</flux:table.column>
            <flux:table.column align="center">Item</flux:table.column>
            <flux:table.column align="center">Unidade de Medida</flux:table.column>
            <flux:table.column align="center">Quantidade</flux:table.column>
            <flux:table.column align="center">Nota Fiscal</flux:table.column>
            <flux:table.column align="center">Data</flux:table.column>

            <flux:table.column align="center">
                <x-sort column-title="Saldo:" model="available">
                    <flux:menu.radio value="">Todos</flux:menu.radio>
                    <flux:menu.radio value="true">Disponíveis</flux:menu.radio>
                </x-sort>
            </flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($supplyItems as $supplyItem)
                <flux:table.row wire:key="supply-item-{{ $supplyItem->id }}">
                    <flux:table.cell align="center">{{ $supplyItem->supply->supply_code }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <a href="{{ route('supplies.show', $supplyItem->supply->id) }}" class="hover:underline">
                            {{ $supplyItem->supply->name }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $supplyItem->supply->client->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $supplyItem->number }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $supplyItem->supply->unit_of_measure }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $supplyItem->formatted_quantity }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <a href="{{ route('supply-invoices.show', $supplyItem->supplyInvoice->id) }}" class="hover:underline">
                            {{ $supplyItem->supplyInvoice->formatted_supply_invoice_code }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $supplyItem->supplyInvoice->formatted_issued_at }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $supplyItem->formatted_balance }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
