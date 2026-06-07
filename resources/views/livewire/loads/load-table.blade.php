<div class="w-full space-y-4">
    <x-table :paginate="$loads">
        <x-slot:header>
            <flux:table.column align="center">Código</flux:table.column>
            <flux:table.column align="center">Data de Corte</flux:table.column>
            <flux:table.column align="center">Turno</flux:table.column>
            <flux:table.column align="center">Máquina</flux:table.column>
            <flux:table.column align="center">Bobinas</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($loads as $load)
                <flux:table.row wire:key="load-{{ $load->id }}">
                    <flux:table.cell align="center">{{ $load->id }}-{{ $load->machine->abbreviation }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->formatted_cutted_at }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->turn }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->machine->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $load->rolls_count }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <x-button icon="eye" variant="ghost" href="{{ route('loads.show', $load) }}" />
                        <x-button icon="pencil" variant="ghost" />
                        <x-button icon="trash" variant="ghost" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
