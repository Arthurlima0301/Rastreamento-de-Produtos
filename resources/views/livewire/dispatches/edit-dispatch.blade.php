<div class="flex items-center gap-2">
    @if ($isEdited === true)
        <span class="font-bold">Código:</span>

        <input type="text" class="p-1 border-1 border-stroke rounded-md" value="{{ $dispatch->id }}" disabled>

        <span class="font-bold">Nota Fiscal:</span>

        <input type="text" class="p-1 border-1 border-stroke rounded-md" wire:model="invoice">
        @error('invoice')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <span class="font-bold">Data:</span>

        <input type="date" class="p-1 border-1 border-stroke rounded-md" wire:model="dispatched_at">

        @error('dispatched_at')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <x-button variant="primary" size="sm" wire:click="save()">Salvar</x-button>
        <x-button variant="danger" size="sm" wire:click="cancel()">Cancelar</x-button>
    @else
        <div class="flex items-center gap-3 w-full">
            <p><strong>Código:</strong> {{ $dispatch->id }}</p>
            <p><span class="font-bold">Nota Fiscal:</span> {{ $invoice }}</p>
            <p><strong>Data:</strong> {{ $dispatch->formatted_dispatched_at }}</p>

            <x-button variant="ghost" icon="pencil" size="sm" wire:click="edit()" />
        </div>
    @endif
</div>
