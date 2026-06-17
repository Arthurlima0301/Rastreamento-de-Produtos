<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$materialInvoices">
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
            @foreach ($materialInvoices as $materialInvoice)
                <flux:table.row wire:key="material-invoice-{{ $materialInvoice->id }}">
                    <flux:table.cell align="center">{{ $materialInvoice->id }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <a href="{{ route('material-invoices.show', $materialInvoice->id) }}" class="hover:underline">
                            {{ $materialInvoice->formatted_invoice_code }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $materialInvoice->formatted_issued_at }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialInvoice->item_materials_count }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <x-button 
                            wire:click="delete({{ $materialInvoice->id }})"    
                            wire:loading.attr="disabled"
                            wire:target="delete({{ $materialInvoice->id }})"
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
