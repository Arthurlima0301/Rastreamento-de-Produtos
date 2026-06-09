<div class="w-full">
    <x-card title="Informações da Máquina">
        <x-slot>
            <div class="flex gap-4">
                <p><strong>Nome:</strong> {{ $machine->name }}</p>
                <p><strong>Sigla:</strong> {{ $machine->abbreviation }}</p>
            </div>
        </x-slot>
    </x-card>


    <x-table :paginate="$loads">
        <x-slot:header>
            <flux:table.column align="center">Código</flux:table.column>
            <flux:table.column align="center">Data de Corte</flux:table.column>
            <flux:table.column align="center">Dia da Semana</flux:table.column>
            <flux:table.column align="center">Turno</flux:table.column>
            <flux:table.column align="center">Máquina</flux:table.column>
            <flux:table.column align="center">Bobinas</flux:table.column>
            <flux:table.column align="center">Peso da Carga</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot name="rows">
            @foreach ($loads as $load)
                <flux:table.row wire:key="load-{{ $load->id }}">
                    <flux:table.cell align="center">{{ $load->machine->abbreviation }}-{{ $load->id }}
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $load->formatted_cutted_at }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->cutted_at->format('l') }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->turn }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->machine->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->rolls_count }}</flux:table.cell>
                    <flux:table.cell align="center">{{ number_format($load->rolls_sum_weight, 2, ',', '.') }}
                    </flux:table.cell>
                    <flux:table.cell align="center">
                        <x-button icon="eye" variant="ghost" href="{{ route('loads.show', $load) }}" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot>

    </x-table>
</div>
