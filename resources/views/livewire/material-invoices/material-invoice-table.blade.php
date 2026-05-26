<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$materialInvoices">
        <x-slot:header>
            <flux:table.column align="center">ID</flux:table.column>
            <flux:table.column align="center">Codigo da Nota</flux:table.column>

            <flux:table.column align="center">
                <x-sort collumn-title="Data de Cadastro" model="parameter">
                    <flux:menu.radio value="desc">Mais Recentes</flux:menu.radio>
                    <flux:menu.radio value="asc">Mais Antigos</flux:menu.radio>
                </x-sort>
            </flux:table.column>

            <flux:table.column align="center">Quantidade de Itens</flux:table.column>
            <flux:table.column align="center">Acoes</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($materialInvoices as $materialInvoice)
                <flux:table.row wire:key="material-invoice-{{ $materialInvoice->id }}">
                    <flux:table.cell align="center">{{ $materialInvoice->id }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialInvoice->formatted_material_invoice_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialInvoice->formatted_created_at }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialInvoice->material_items_count }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <x-button href="{{ route('material-invoices.show', $materialInvoice->id) }}" variant="ghost" icon="eye" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
