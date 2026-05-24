<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$items">
        <x-slot:header>
            <flux:table.column align="center">Código</flux:table.column>
            <flux:table.column align="center">Descrição</flux:table.column>
            <flux:table.column align="center">Cliente</flux:table.column>
            <flux:table.column align="center">Item</flux:table.column>
            <flux:table.column align="center">Unidade de Medida</flux:table.column>
            <flux:table.column align="center">Quantidade</flux:table.column>
            <flux:table.column align="center">Nota Fiscal</flux:table.column>
            <flux:table.column align="center">Data</flux:table.column>

            <flux:table.column align="center">
                <x-sort collumn-title="Saldo:" model="available">
                    <flux:menu.radio value="">Todos</flux:menu.radio>
                    <flux:menu.radio value="true">Disponíveis</flux:menu.radio>
                </x-sort>
            </flux:table.column>

        </x-slot:header>

        <x-slot:rows>
            @foreach ($items as $item)
                <flux:table.row wire:key="item-{{ $item->id }}">
                    <flux:table.cell align="center">{{ $item->supply->supply_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $item->supply->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $item->supply->client->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $item->number }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $item->supply->unit_of_measure }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $item->formatted_quantity }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $item->invoice->formatted_invoice_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $item->invoice->formatted_issued_at }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $item->formatted_balance }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
