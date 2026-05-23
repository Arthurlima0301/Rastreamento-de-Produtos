<div>
        <flux:card class="max-h-[85vh] overflow-y-auto">
            <form wire:submit.prevent="save" class="space-y-4">

                <div class="flex p4 items-center justify-between">
                    <flux:heading size="xl">Selecionados</flux:heading>
                    <x-button type="button" class="w-auto" variant="ghost" wire:click="clearSelection">Limpar
                        Seleção</x-button>
                </div>

                @if ($errors->isNotEmpty())
                    <p class="text-sm text-center text-red-500">{{ $errors->first() }}</p>
                @endif

                @if (empty($selectedItems))
                    <p class="text-sm text-gray-500">Nenhum item selecionado. Seleciona itens para adicionar à saída.</p>
                @else
                    @foreach ($selectedItems as $index => $item)
                        <div class="flex items-center justify-between gap-3" wire:key="{{ $item['id'] }}">

                            <p class="text-sm w-full">{{ $item['supply_name'] }}</p>
                            <x-input type="decimal" wire:model="selectedItems[{{ $index }}][quantity]"
                                class="w-1" placeholder="Quantidade" />

                            <x-button variant="ghost" icon="x-mark" class="p-4"
                                wire:click="removeItem({{ $item['id'] }})" />
                        </div>
                    @endforeach
                @endif

                <x-button type="submit" variant="primary" class="w-full">Salvar Saída</x-button>
            </form>
        </flux:card>
</div>
