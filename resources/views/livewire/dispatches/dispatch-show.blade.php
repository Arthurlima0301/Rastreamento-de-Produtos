<div class="w-full">
    <x-card title="Detalhes da Saída">
        <x-slot name="slot">
            <livewire:dispatches.edit-dispatch :dispatchId="$dispatch->id" />

            <flux:dropdown>
                <x-button icon="ellipsis-horizontal" />

                <flux:menu>
                    <flux:menu.item class="cursor-pointer" icon="square-3-stack-3d" href="{{ route('dispatches.pallets', $dispatch ), }}">
                        Adicionar Pallets
                    </flux:menu.item>
                    <flux:menu.item class="cursor-pointer" icon="cube" href="{{ route('dispatches.supplies', $dispatch) }}">
                        Adicionar Insumos
                    </flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </x-slot>
    </x-card>

    <flux:button.group class="w-full">
        <x-button wire:click="toggleTab('pallets')" variant="{{ $tab == 'pallets' ? 'primary' : 'ghost' }}"
            icon="bars-4">Pallets</x-button>
        <x-button wire:click="toggleTab('supplies')" variant="{{ $tab == 'supplies' ? 'primary' : 'ghost' }}"
            icon="inbox-stack">Insumos</x-button>
    </flux:button.group>

    @if ($tab === 'pallets')
        <livewire:dispatches.dispatch-show-pallets :dispatchId="$dispatch->id" />
    @elseif($tab === 'supplies')
        <livewire:dispatches.dispatch-show-supplies :dispatchId="$dispatch->id" />
    @endif
</div>
