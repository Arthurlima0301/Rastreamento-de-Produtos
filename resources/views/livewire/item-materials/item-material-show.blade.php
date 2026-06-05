<div class="w-full">
    <x-card title="Detalhes do Material do Item">
        <x-slot name="slot">
            <div class="flex gap-3"> 
                <p><strong>NF: </strong> {{ $itemMaterial->materialInvoice->formatted_invoice_code }}</p>
                <p><strong>Item: </strong> {{ $itemMaterial->number }}</p>
                <p><strong>Papel: </strong> {{ $itemMaterial->material->paper }}</p>
                <p><strong>Gramatura: </strong> {{ $itemMaterial->material->formatted_grammage }}</p>
                <p><strong>Rolo: </strong> {{ $itemMaterial->material->roll }}</p>
            </div>
        </x-slot>
    </x-card>


    <x-search-input />
    <x-table>
        <x-slot:header>
            <flux:table.column align="center">Código</flux:table.column>
            <flux:table.column align="center">Peso</flux:table.column>
            <flux:table.column align="center">
                <x-sort collumnTitle="Status" model="filter_status">
                    <flux:menu.radio value="">Todas</flux:menu.radio>
                    <flux:menu.radio value="EM_ESTOQUE">Em Estoque</flux:menu.radio>
                    <flux:menu.radio value="CORTADA">Cortada</flux:menu.radio>
                </x-sort>
            </flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($rolls as $roll)
                <flux:table.row wire:key="roll-{{ $roll->id }}">
                    <flux:table.cell align="center">{{ $roll->label }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->formatted_weight }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->status }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
