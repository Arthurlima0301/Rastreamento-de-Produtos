<div class="w-full">
    <x-card title="Detalhes do Material do Item">
        <x-slot name="slot">
            <div class="flex items-center gap-3">
                <p><strong>NF: </strong> {{ $itemMaterial->materialInvoice->formatted_invoice_code }}</p>
                <p><strong>Item: </strong> {{ $itemMaterial->number }}</p>
                <p><strong>Papel: </strong> {{ $itemMaterial->material->paper }}</p>
                <p><strong>Gramatura: </strong> {{ $itemMaterial->material->formatted_grammage }}</p>
                <p><strong>Rolo: </strong> {{ $itemMaterial->material->roll }}</p>

                <flux:dropdown label="Ações">
                    <flux:button icon:trailing="ellipsis-horizontal"></flux:button>

                    <flux:navmenu>
                        <flux:navmenu.item icon="plus-circle" href="{{ route('roll.create', $itemMaterial) }}">
                            Adicionar Bobina(s)
                        </flux:navmenu.item>
                    </flux:navmenu>
                </flux:dropdown>
            </div>
        </x-slot>
    </x-card>

    <x-error-message />
    <x-success-message />

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
            <flux:table.column align="center">Carga</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($rolls as $roll)
                <flux:table.row wire:key="roll-{{ $roll->id }}">
                    <flux:table.cell align="center">{{ $roll->label }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->formatted_weight }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->status }}</flux:table.cell>
                    <flux:table.cell align="center">
                        @if ($roll->cutLoad)
                            <a href="{{ route('loads.show', $roll->cutLoad) }}" class="hover:underline cursor-pointer">
                                {{ $roll->cutLoad->machine->abbreviation }} - {{ $roll->cutLoad->number }}
                            </a>
                        @endif
                    </flux:table.cell>
                    <flux:table.cell align="center">
                        <div class="flex justify-center gap-2">
                            <x-button icon="pencil" variant="primary" href="{{ route('rolls.edit', $roll) }}" />
                            <x-button icon="trash" variant="primary" color="red" wire:click="deleteRoll({{ $roll->id }})" />
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
