<div class="w-full">
    <x-error-message />

    <x-card title="Detalhes da Saída">
        <x-slot name="slot">
            <livewire:dispatches.edit-dispatch :dispatchId="$dispatch->id" />
        </x-slot>
    </x-card>

    <x-table>
        <x-slot:header>
            <flux:table.column align="center">Quantidade</flux:table.column>
            <flux:table.column align="center">Unidade de Medida</flux:table.column>
            <flux:table.column align="center">Código do Insumo</flux:table.column>
            <flux:table.column align="center">Nome do Insumo</flux:table.column>
            <flux:table.column align="center">Nota Fiscal Origem</flux:table.column>
            <flux:table.column align="center">Número do Item</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($dispatch->dispatchItems as $dispatchItem)
                <flux:table.row>
                    <flux:table.cell align="center">{{ $dispatchItem->formatted_quantity }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $dispatchItem->supplyItem->supply->unit_of_measure }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $dispatchItem->supplyItem->supply->supply_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $dispatchItem->supplyItem->supply->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $dispatchItem->supplyItem->supplyInvoice->formatted_supply_invoice_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $dispatchItem->supplyItem->number }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
