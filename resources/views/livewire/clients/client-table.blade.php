<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$clients">
        <x-slot:header>
            <flux:table.column align="center">Nome</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($clients as $client)
                <flux:table.row wire:key="client-{{ $client->id }}">
                    <flux:table.cell align="center">{{ $client->name }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <div class="flex justify-center gap-2">
                            <x-button href="{{ route('clients.edit', $client->id) }}" variant="ghost" icon="pencil" />

                            <x-button type="button" variant="primary" color="red" icon="trash" wire:click="destroy({{ $client->id }})" />
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
