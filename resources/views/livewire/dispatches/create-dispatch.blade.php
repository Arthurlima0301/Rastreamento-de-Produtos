<div class="flex w-full max-w-full flex-col gap-4 overflow-hidden xl:flex-row">
    <div class="">
        <x-search-input />

        <x-table :paginate="$items">
            <x-slot:header>
                <flux:table.column align="center">Código</flux:table.column>
                <flux:table.column align="center">Descrição</flux:table.column>
                <flux:table.column align="center">Item</flux:table.column>
                <flux:table.column align="center">Unidade de Medida</flux:table.column>
                <flux:table.column align="center">Quantidade</flux:table.column>
                <flux:table.column align="center">Nota Fiscal</flux:table.column>
                <flux:table.column align="center">Data</flux:table.column>
                <flux:table.column align="center">Saldo</flux:table.column>
                <flux:table.column align="center">Ações</flux:table.column>
            </x-slot:header>

            <x-slot:rows>
                @foreach ($items as $item)
                    <flux:table.row wire:key="dispatch-item-{{ $item->id }}">
                        <flux:table.cell align="center">{{ $item->supply->supply_code }}</flux:table.cell>
                        <flux:table.cell align="center">{{ $item->supply->name }}</flux:table.cell>
                        <flux:table.cell align="center">{{ $item->number }}</flux:table.cell>
                        <flux:table.cell align="center">{{ $item->supply->unit_of_measure }}</flux:table.cell>
                        <flux:table.cell align="center">{{ $item->formatted_quantity }}</flux:table.cell>
                        <flux:table.cell align="center">{{ $item->invoice->formatted_invoice_code }}</flux:table.cell>
                        <flux:table.cell align="center">{{ $item->invoice->issued_at }}</flux:table.cell>
                        <flux:table.cell align="center">{{ $item->formatted_balance }}</flux:table.cell>
                        <flux:table.cell align="center">
                            <x-button
                                variant="primary"
                                color="{{ isset($selectedItems[$item->id]) ? 'gray' : 'blue' }}"
                                class="w-full"
                                wire:click="selectItem({{ $item->id }}, '{{ $item->supply->name }}')"
                            >
                                {{ isset($selectedItems[$item->id]) ? 'Selecinado' : 'Selecionar' }}
                            </x-button>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </x-slot:rows>
        </x-table>
    </div>

    <x-selected-items-list :selectedItems="$selectedItems" />
</div>
