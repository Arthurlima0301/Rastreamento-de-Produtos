<div>

    <x-search-input />
    <x-table>
        <x-slot:header>
            <flux:table.column align="center">Código</flux:table.column>
            <flux:table.column align="center">Peso</flux:table.column>
            <flux:table.column align="center">
                <x-sort column-title="Status" model="statusFilter">
                    <flux:menu.radio value="">Todas</flux:menu.radio>
                    <flux:menu.radio value="EM_ESTOQUE">Em Estoque</flux:menu.radio>
                    <flux:menu.radio value="CORTADA">Cortada</flux:menu.radio>
                </x-sort>
            </flux:table.column>
            <flux:table.column align="center">Defeito</flux:table.column>
            <flux:table.column align="center">Peso do Defeito</flux:table.column>
            <flux:table.column align="center">Carga</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($rolls as $roll)
                <flux:table.row wire:key="roll-{{ $roll->id }}">
                    <flux:table.cell align="center">{{ $roll->label }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->formatted_weight }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->status }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->defect ?? '-' }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->formatted_defect_weight ?? '-' }}</flux:table.cell>
                    <flux:table.cell align="center">
                        @if ($roll->cutLoad)
                            <a href="{{ route('loads.show', $roll->cutLoad) }}" class="hover:underline cursor-pointer">
                                {{ $roll->cutLoad->machine->abbreviation }}-{{ $roll->cutLoad->id }}
                            </a>
                        @else
                            <p>-</p>
                        @endif
                    </flux:table.cell>
                    <flux:table.cell align="center">
                        <div class="flex justify-center gap-2">
                            <x-button icon="pencil" variant="ghost" href="{{ route('rolls.edit', $roll) }}" />
                            <x-button icon="trash" variant="primary" color="red"
                                wire:click="deleteRoll({{ $roll->id }})" />
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
