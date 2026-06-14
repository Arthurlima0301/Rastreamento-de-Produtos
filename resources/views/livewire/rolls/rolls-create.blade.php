<div class="w-full">
    <x-card title="Adicionar Bobinas">
        <x-slot name="slot">
            <p><strong>NF: </strong> {{ $itemMaterial->materialInvoice->formatted_invoice_code }}</p>
            <p><strong>Nº do Item: </strong> {{ $itemMaterial->number }}</p>
            <p><strong>Papel: </strong> {{ $itemMaterial->material->paper }}</p>
            <p><strong>Gramatura: </strong> {{ $itemMaterial->material->formatted_grammage }}</p>
            <p><strong>Rolo: </strong> {{ $itemMaterial->material->roll }}</p>
        </x-slot>
    </x-card>

    <x-success-message />

    <flux:card>
        <form wire:submit.prevent="save" class="flex flex-col gap-4 mt-4" >
            @error('rollLabel')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <x-input label="Lote da Bobina" placeholder="Digite o lote da bobina" wire:model="rollBatch" autofocus />
            @error('rollBatch')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror


            <x-input label="Volume da Bobina" placeholder="Digite o volume da bobina" wire:model="rollVolume"
                x-on:focus-roll-vol.window="$el.focus()" />
            @error('rollVolume')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <x-input label="Peso" placeholder="Digite o peso da bobina" wire:model="rollWeight" />
            @error('rollWeight')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <x-button type="submit">Adicionar Bobina</x-button>
        </form>
    </flux:card>
</div>
