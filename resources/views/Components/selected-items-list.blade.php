@props(['selectedItems'])


<div class="">
    <flux:card class="flex-1 max-h-[85vh] overflow-y-auto">
        <form action="{{ route('dispatches.store') }}" method="POST" class="space-y-4">
            @csrf
            <flux:heading size="lg">Selecionados</flux:heading>

            @if(empty($selectedItems))
                <p class="text-sm text-gray-500">Nenhum item selecionado. Seleciona itens para adicionar à saída.</p>
            @else
                @foreach ($selectedItems as $index => $item)
                    <div class="flex items-center justify-between gap-3">
                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item['id'] }}" />

                        <p class="text-sm w-full">{{ $item['supply_name'] }}</p>
                        <x-input type="decimal" name="items[{{ $index }}][quantity]" class="w-full"
                            placeholder="Quantidade" />
                    </div>
                @endforeach
            @endif
            <x-button type="submit" variant="primary" class="w-full">Salvar Saída</x-button>
        </form>
    </flux:card>
</div>


