<div class="flex items-center gap-2">
    @if($isEdited === true)
        <span class="font-bold">Nota Fiscal:</span>
      
        <input type="text" class="p-1 border-1 border-stroke rounded-md" wire:model="invoice">

        @error('invoice')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <x-button variant="primary" size="sm" wire:click="save()">Salvar</x-button>
        <x-button variant="danger" size="sm" wire:click="cancel()">Cancelar</x-button>
    @else
        <p><span class="font-bold">Nota Fiscal:</span> {{ $invoice }}</p>
       
        <x-button variant="primary" color="amber" size="sm" wire:click="edit()">Editar</x-button>
    @endif
</div>
