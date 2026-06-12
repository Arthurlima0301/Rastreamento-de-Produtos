<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$loads">
        <x-slot:header>
            <flux:table.column align="center">Código</flux:table.column>
            <flux:table.column align="center">Data do Corte</flux:table.column>
            <flux:table.column align="center">Turno</flux:table.column>
            <flux:table.column align="center">Máquina</flux:table.column>
            <flux:table.column align="center">Quantidade de Bobinas</flux:table.column>
            <flux:table.column align="center">Peso da Carga</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($loads as $load)
                <flux:table.row wire:key="load-{{ $load->id }}">
                    <flux:table.cell align="center">
                        <a href="{{ route('loads.show', $load) }}" class="hover:underline">
                            {{ $load->machine->abbreviation }}-{{ $load->id }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $load->formatted_cutted_at }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->turn }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->machine->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->rolls_count }}</flux:table.cell>
                    <flux:table.cell align="center">{{ number_format($load->rolls_sum_weight, 2, ',', '.') }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <x-button icon="trash" variant="ghost" wire:click="deleteLoad({{ $load->id }})" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
