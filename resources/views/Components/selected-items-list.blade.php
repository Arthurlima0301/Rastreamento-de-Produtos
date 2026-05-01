<div class="flex-1">
    <form action="{{ route('dispatches.store') }}" method="POST" class="max-h-[85vh] p-4 bg-surface border-2 border-stroke overflow-y-auto rounded shadow">
        @csrf
        <h1 class="text-xl font-bold">Selecionados</h1>
        
        @foreach ($selectedItems as $index => $item)
                <div class="flex items-center justify-between mb-2">
                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item['id'] }}" />
                
                <p class="w-full">{{ $item['supply_name'] }}</p>
                <input type="number" name="items[{{ $index }}][quantity]" class="w-full border-2 border-stroke p-2 rounded" placeholder = "Quantidade" />
            </div>
        @endforeach

        <button type="submit" class="w-full bg-primary text-muted p-2 cursor-pointer rounded">Salvar Saída</button>
    </form>
</div>
