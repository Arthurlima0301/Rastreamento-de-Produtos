<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$dispatches">
        <x-slot:header>
            <flux:table.column align="center">ID</flux:table.column>
            <flux:table.column align="center">
                Data:
                <select name="field" id="field" wire:model.live="parameter">
                    <option value="desc" class="text-mtext">Mais Recentes</option>
                    <option value="asc" class="text-mtext">Mais Antigas</option>
                </select>
            </flux:table.column>
            <flux:table.column align="center">Nota Fiscal</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($dispatches as $dispatch)
                <flux:table.row wire:key="dispatch-{{ $dispatch->id }}">
                    <flux:table.cell align="center">{{ $dispatch->id }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $dispatch->dispatched_at }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $dispatch->invoice ?? 'N/A' }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <x-button href="{{ route('dispatches.show', $dispatch->id) }}" variant="ghost" icon="eye" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
