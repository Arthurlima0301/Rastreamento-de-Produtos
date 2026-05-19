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
                    <flux:table.cell align="center">{{ $supply->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $supply->supply_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $supply->unit_of_measure }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $supply->client->name }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <div class="flex justify-center gap-2">
                            <x-button href="{{ route('supplies.show', $supply->id) }}" variant="ghost" icon="eye" />
                            <x-button href="{{ route('supplies.edit', $supply->id) }}" variant="ghost" icon="pencil" />

                            <form action="{{ route('supplies.destroy', $supply->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger" icon="trash" />
                            </form>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
