<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$supplies">
        <x-slot:header>
            <flux:table.column align="center">Nome</flux:table.column>
            <flux:table.column align="center">Código</flux:table.column>
            <flux:table.column align="center">Unidade de Medida</flux:table.column>
            <flux:table.column align="center">Cliente</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($supplies as $supply)
                <flux:table.row wire:key="supply-{{ $supply->id }}">
                    <flux:table.cell align="center">
                        <a href="{{ route('supplies.show', $supply->id) }}" class="hover:underline">
                            {{ $supply->name }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $supply->supply_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $supply->unit_of_measure }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $supply->client->name }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <div class="flex justify-center gap-2">
                            <x-button href="{{ route('supplies.edit', $supply->id) }}" variant="ghost" icon="pencil" />
                            <x-button type="button" variant="danger" icon="trash" wire:click="destroy({{ $supply->id }})" />
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
