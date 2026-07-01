<div class="w-full">
    <x-card title="Detalhes do Item Material">
        <x-slot name="slot">
            <p><strong>NF: </strong> {{ $itemMaterial->materialInvoice->formatted_invoice_code }}</p>
            <p><strong>Nº do Item: </strong> {{ $itemMaterial->number }}</p>
            <p><strong>Papel: </strong> {{ $itemMaterial->material->paper }}</p>
            <p><strong>Gramatura: </strong> {{ $itemMaterial->material->formatted_grammage }}</p>
            <p><strong>Peso Líquido: </strong> {{ $itemMaterial->material->formatted_package_net_weight }}</p>

                @if ((float) $totalWeight !== (float) $itemMaterial->total_weight)
                    <flux:tooltip class="cursor-default"
                        content="A soma total dos pesos das bobinas é diferente do peso total do item material."
                        position="bottom">
                        <p class="text-red-500"> Peso Total: {{ number_format($totalWeight, 2, ',', '.') }}</p>

                    </flux:tooltip>
                @else
                    <p>
                        <strong>Soma dos Pesos: </strong>
                        {{ number_format($totalWeight, 2, ',', '.') }}
                    </p>
                @endif
                <flux:dropdown label="Ações">
                    <flux:button icon:trailing="ellipsis-horizontal"></flux:button>

                    <flux:navmenu>
                        <flux:navmenu.item icon="plus-circle" href="{{ route('roll.create', $itemMaterial) }}">
                            Adicionar Bobina(s)
                        </flux:navmenu.item>
                        <flux:navmenu.item icon="arrow-path" wire:click="generatePallets" class="cursor-pointer">
                            Gerar Pallets
                        </flux:navmenu.item>
                    </flux:navmenu>
                </flux:dropdown>
        </x-slot>
    </x-card>

    <x-error-message />
    <x-success-message />

    <flux:button.group class="w-full">
        <x-button wire:click="toggleTab('rolls')" variant="{{ $page == 'rolls' ? 'primary' : 'ghost' }}"
            icon="circle-stack">Bobinas</x-button>
        <x-button wire:click="toggleTab('losses')" variant="{{ $page == 'losses' ? 'primary' : 'ghost' }}"
            icon="percent-badge">Calcular Perdas</x-button>
    </flux:button.group>


    @if ($page == 'rolls')
        <livewire:item-materials.item-material-rolls :itemMaterialId="$itemMaterial->id" />
    @elseif ($page == 'losses')
        <livewire:item-materials.item-material-losses :itemMaterial="$itemMaterial" />
    @endif
</div>
