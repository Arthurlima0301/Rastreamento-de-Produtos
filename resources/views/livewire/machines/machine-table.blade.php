<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$machines">
        <x-slot:header>
            <flux:table.column align="center">Nome</flux:table.column>
            <flux:table.column align="center">Sigla</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($machines as $machine)
                <flux:table.row wire:key="machine-{{ $machine->id }}">
                    <flux:table.cell align="center">{{ $machine->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $machine->abbreviation }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <div class="flex justify-center gap-2">
                            <x-button href="{{ route('machines.edit', $machine->id) }}" variant="ghost" icon="pencil" />

                            <x-button type="button" variant="danger" icon="trash" wire:click="destroy({{ $machine->id }})" />
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
