<div>
    <x-table :paginate="$loads">

        <x-slot name="header">
            <flux:table.column align="center">Código</flux:table.column>
            <flux:table.column align="center">Turno</flux:table.column>
            <flux:table.column align="center">Bobinas</flux:table.column>
            <flux:table.column align="center">Pallets</flux:table.column>
            <flux:table.column align="center">Peso Total</flux:table.column>
            <flux:table.column align="center">Consumido</flux:table.column>
        </x-slot>

        <x-slot name="rows">
            @foreach ($loads as $load)
                <flux:table.row wire:key="load-{{ $load->id }}">
                    <flux:table.cell align="center">
                        <a href="{{ route('loads.show', $load) }}" class="hover:underline"> 
                            {{ $load->machine->abbreviation . '-' . $load->id ?? '-' }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $load->turn }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->total_rolls }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->total_pallets }}</flux:table.cell>
                    <flux:table.cell align="center">{{ number_format($load->total_rolls_weight, 2, ',', '.') }}</flux:table.cell>
                    <flux:table.cell align="center">{{ number_format($load->total_pallets_weight, 2, ',', '.') }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot>
    </x-table>
</div>
