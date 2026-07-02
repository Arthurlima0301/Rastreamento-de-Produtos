<div class="w-full">
    <x-card title="Detalhes da Carga">
        <x-slot name="slot">
            <livewire:loads.edit-load :load="$load" />

            <flux:dropdown>
                <x-button variant="ghost" icon="ellipsis-horizontal" size="sm" />

                <flux:menu>
                    <flux:menu.item href="{{ route('loads.add-rolls', $load) }}" icon="plus">Adicionar Bobina(s)
                    </flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </x-slot>
    </x-card>

    <x-success-message />

    <flux:button.group class="w-full">
        <x-button wire:click="toggleTab('rolls')" variant="{{ $page == 'rolls' ? 'primary' : 'ghost' }}"
            icon="circle-stack">Bobinas ({{ $totalRolls }})</x-button>
        <x-button wire:click="toggleTab('pallets')" variant="{{ $page == 'pallets' ? 'primary' : 'ghost' }}"
            icon="bars-4">Pallets ({{ $totalPallets }})</x-button>
    </flux:button.group>

    @if ($page == 'rolls')
        <livewire:loads.load-rolls :load="$load" />
    @elseif ($page == 'pallets')
        <livewire:loads.load-pallets :load="$load" />
    @endif
</div>
