<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$invoices">
        <x-slot:header>
            <flux:table.column align="center">ID</flux:table.column>
            <flux:table.column align="center">Código da Nota</flux:table.column>

            <flux:table.column align="center">
                
                <x-sort collumn-title="Data de Emissão" model="parameter">
                    <flux:menu.radio value="desc">Mais Recentes</flux:menu.radio>
                    <flux:menu.radio value="asc">Mais Antigos</flux:menu.radio>
                </x-sort>

            </flux:table.column>

            <flux:table.column align="center">Quantidade de Itens</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($invoices as $invoice)
                <flux:table.row wire:key="invoice-{{ $invoice->id }}">
                    <flux:table.cell align="center">{{ $invoice->id }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $invoice->formatted_invoice_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $invoice->issued_at }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $invoice->items_count }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <x-button href="{{ route('invoices.show', $invoice->id) }}" variant="ghost" icon="eye" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
