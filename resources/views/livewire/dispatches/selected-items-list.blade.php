<div>
    <flux:card class="max-h-[85vh] space-y-4 overflow-y-auto">

        <div class="flex items-center justify-between">
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
                <div class="flex items-center gap-6" wire:key="{{ $item['id'] }}">

                    <p class="text-sm w-full">{{ $item['supply_name'] }}</p>

                    <x-input type="decimal" wire:model="selectedItems[{{ $index }}][quantity]" class="w-1"
                        placeholder="Quantidade" />

                    <x-button variant="ghost" icon="x-mark" class="p-4"
                        wire:click="removeItem({{ $item['id'] }})" />
                </div>
            @endforeach

            <flux:modal.trigger name="confirm">
                <x-button type="button" variant="primary" class="w-full">Salvar Saída</x-button>
            </flux:modal.trigger>
        @endif
    </flux:card>


    <flux:modal name="confirm">
        <form wire:submit.prevent="save" class="space-y-4">
            <flux:heading size="lg">Confirmar Saída</flux:heading>
            <p>Tem certeza que deseja salvar esta saída?</p>

            <div class="flex justify-between gap-2">
                <x-button type="button" variant="primary" color="red" class="w-full"
                    x-on:click="$flux.modal('confirm').close()">Cancelar</x-button>

                <x-button type="submit" variant="primary"
                    x-on:click="$flux.modal('confirm').close()">Confirmar</x-button>
            </div>
        </form>
    </flux:modal>

</div>
