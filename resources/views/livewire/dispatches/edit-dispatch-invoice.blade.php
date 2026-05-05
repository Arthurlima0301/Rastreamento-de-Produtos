<div class="flex items-center gap-2">
    @if($isEdited === true)
        <span class="font-bold">Nota Fiscal:</span>
      
        <input type="text" class="p-1 border-1 border-stroke rounded-md" wire:model="invoice">

        @error('invoice')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <button class="p-1 bg-primary text-muted  rounded-md cursor-pointer" wire:click="save()">Salvar</button>
        <button class="p-1 bg-danger text-muted rounded-md cursor-pointer" wire:click="cancel()">Cancelar</button>
    @else
        <p><span class="font-bold">Nota Fiscal:</span> {{ $invoice }}</p>
       
        <button class="p-1 bg-warning text-muted  rounded-md cursor-pointer" wire:click="edit()">Editar</button>
    @endif
</div>