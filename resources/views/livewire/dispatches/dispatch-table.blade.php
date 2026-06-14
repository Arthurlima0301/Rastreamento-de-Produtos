<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$dispatches">
        <x-slot:header>
            <flux:table.column align="center">ID</flux:table.column>
            <flux:table.column align="center">
                <x-sort column-title="Data de Emissão" model="sortDirection">
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
                    <flux:table.cell align="center">
                        <a href="{{ route('dispatches.show', $dispatch->id) }}" class="hover:underline">
                            {{ $dispatch->id }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $dispatch->formatted_dispatched_at }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $dispatch->invoice ?? 'N/A' }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <x-button href="{{ route('dispatches.show', $dispatch->id) }}" icon="arrow-up-right" />

                        <flux:modal.trigger :name="'confirm-'.$dispatch->id">
                            <x-button variant="primary" color="red" icon="trash" />
                        </flux:modal.trigger>
                    </flux:table.cell>
                </flux:table.row>

                <flux:modal :name="'confirm-'.$dispatch->id">
                    <div class="space-y-4">
                        <flux:heading size="lg">Confirmar Exclusão</flux:heading>
                        <p>Tem certeza que deseja excluir esta saída?</p>

                        <div class="flex justify-end gap-2">
                            <flux:modal.close>
                                <x-button variant="ghost">
                                    Cancelar
                                </x-button>
                            </flux:modal.close>

                            <x-button wire:click="destroy({{ $dispatch->id }})" variant="primary" color="red" icon="trash">
                                Continuar
                            </x-button>
                        </div>
                    </div>
                </flux:modal>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
