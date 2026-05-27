<div class="w-full">
    <x-error-message />

    <x-card title="Detalhes da Nota Fiscal">
        <x-slot name="slot">
            <p><strong>Código:</strong> {{ $invoice->formatted_invoice_code }}</p>
            <p><strong>Data de Emissão:</strong> {{ $invoice->formatted_issued_at }}</p>
            <p><strong>Quantidade de Itens:</strong> {{ $invoice->items_count }}</p>
        </x-slot>
    </x-card>

    <x-table :empty="$invoice->items->isEmpty()" empty-colspan="4">
        <x-slot:header>
            <flux:table.column align="center">Item</flux:table.column>
            <flux:table.column align="center">Insumo</flux:table.column>
            <flux:table.column align="center">Quantidade</flux:table.column>
            <flux:table.column align="center">Unidade de Medida</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($invoice->items as $invoiceItem)
                <flux:table.row>
                    <flux:table.cell align="center">{{ $invoiceItem->number }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $invoiceItem->supply->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $invoiceItem->formatted_quantity }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $invoiceItem->supply->unit_of_measure }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
