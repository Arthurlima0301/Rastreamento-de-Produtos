<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$dispatches">
        <x-slot:header>
            <flux:table.column align="center">ID</flux:table.column>
            <flux:table.column align="center">
                <x-sort collumn-title="Data de Emissão" model="parameter">
                    <flux:menu.radio value="desc">Mais Recentes</flux:menu.radio>
                    <flux:menu.radio value="asc">Mais Antigos</flux:menu.radio>
                </x-sort>
            </flux:table.column>
            <flux:table.column align="center">Nota Fiscal</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($dispatches as $dispatch)
                <flux:table.row wire:key="dispatch-{{ $dispatch->id }}">
                    <flux:table.cell align="center">{{ $dispatch->id }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $dispatch->formatted_dispatched_at }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $dispatch->invoice ?? 'N/A' }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <x-button href="{{ route('dispatches.show', $dispatch->id) }}" variant="ghost" icon="eye" />
                        <x-button wire:click="destroy({{ $dispatch->id }})" variant="primary" color="red" icon="trash" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
