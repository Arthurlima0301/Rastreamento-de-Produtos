<div class="w-full">
    <x-card title="Criar Saída" />

    <section class="flex w-full max-w-full flex-col gap-4 overflow-hidden xl:flex-row">
        <div class="">
            <x-search-input />

            <x-table :paginate="$supplyItems">
                <x-slot:header>
                    <flux:table.column align="center">Código</flux:table.column>
                    <flux:table.column align="center">Descrição</flux:table.column>
                    <flux:table.column align="center">Item</flux:table.column>
                    <flux:table.column align="center">Unidade de Medida</flux:table.column>
                    <flux:table.column align="center">Quantidade</flux:table.column>
                    <flux:table.column align="center">Nota Fiscal</flux:table.column>
                    <flux:table.column align="center">Data</flux:table.column>
                    <flux:table.column align="center">Saldo</flux:table.column>
                    <flux:table.column align="center">
                        <x-button wire:click="orderByMostUssed" :icon="$orderByFrequency ? 'chevron-double-up' : ''">Mais Usados</x-button>
                    </flux:table.column>
                    <flux:table.column align="center">Ações</flux:table.column>
                </x-slot:header>

                <x-slot:rows>
                    @foreach ($supplyItems as $supplyItem)
                        <flux:table.row wire:key="dispatch-supply-item-{{ $supplyItem->id }}">
                            <flux:table.cell align="center">{{ $supplyItem->supply->supply_code }}</flux:table.cell>
                            <flux:table.cell align="center">{{ $supplyItem->supply->name }}</flux:table.cell>
                            <flux:table.cell align="center">{{ $supplyItem->number }}</flux:table.cell>
                            <flux:table.cell align="center">{{ $supplyItem->supply->unit_of_measure }}</flux:table.cell>
                            <flux:table.cell align="center">{{ $supplyItem->formatted_quantity }}</flux:table.cell>
                            <flux:table.cell align="center">{{ $supplyItem->supplyInvoice->formatted_supply_invoice_code }}</flux:table.cell>
                            <flux:table.cell align="center">{{ $supplyItem->supplyInvoice->formatted_issued_at }}</flux:table.cell>
                            <flux:table.cell align="center">{{ $supplyItem->formatted_balance }}</flux:table.cell>
                            <flux:table.cell align="center">{{ $supplyItem->frequence ?? '-'}}</flux:table.cell>
                            <flux:table.cell align="center">
                                <x-dispatches.select-supply-item-button :supply-item-id="$supplyItem->id" :supply-name="$supplyItem->supply->name" />
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </x-slot:rows>
            </x-table>
        </div>

        <livewire:dispatches.selected-supply-items-list :key="'dispatch-selected-supply-items-list'" />
    </section>
</div>
