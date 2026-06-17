<div class="w-full space-y-4">
    <x-error-message />
    <x-search-input />

    <x-table :paginate="$supplyInvoices">
        <x-slot:header>
            <flux:table.column align="center">ID</flux:table.column>
            <flux:table.column align="center">Código da Nota</flux:table.column>

            <flux:table.column align="center">
                
                <x-sort column-title="Data de Emissão" model="sortDirection">
                    <flux:menu.radio value="desc">Mais Recentes</flux:menu.radio>
                    <flux:menu.radio value="asc">Mais Antigos</flux:menu.radio>
                </x-sort>

            </flux:table.column>

            <flux:table.column align="center">Quantidade de Itens</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($supplyInvoices as $supplyInvoice)
                <flux:table.row wire:key="supply-invoice-{{ $supplyInvoice->id }}">
                    <flux:table.cell align="center">{{ $supplyInvoice->id }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <a href="{{ route('supply-invoices.show', $supplyInvoice->id) }}" class="hover:underline">
                            {{ $supplyInvoice->formatted_supply_invoice_code }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $supplyInvoice->formatted_issued_at }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $supplyInvoice->supply_items_count }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <x-button 
                            wire:click="delete({{$supplyInvoice->id}})" 
                            wire:loading.attr="disabled"
                            wire:target="delete({{ $supplyInvoice->id }})"
                            variant="primary"
                            color="red"
                            icon="trash" 
                        />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
