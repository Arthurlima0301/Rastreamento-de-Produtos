<div>
    <x-search-input />

    <x-table :paginate="$pallets">

        <x-slot name="header">
            <flux:table.column align="center">Rótulo</flux:table.column>
            <flux:table.column align="center">Peso Líquido P.</flux:table.column>
            <flux:table.column align="center">Carga</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot>

        <x-slot name="rows">
            @foreach ($pallets as $pallet)
                <flux:table.row wire:key="pallet-{{ $pallet->id }}">
                    <flux:table.cell align="center">{{ $pallet->formatted_label }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $pallet->formatted_package_net_weight }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <a href="{{ route('loads.show', $pallet->cutLoad->id) }}" class="hover:underline">
                            {{ $pallet->cutLoad->machine->abbreviation . '-' . $pallet->cutLoad->id ?? '-' }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">
                        <flux:button icon="pencil" variant="ghost" />
                        <flux:button icon="trash" variant="primary" color="red" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot>
    </x-table>
</div>
