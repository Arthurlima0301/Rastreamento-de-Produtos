<div class="w-full">
    <x-card title="Adicionar Bobina(s)">
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
            @error('roll_label')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <x-input label="Lote da Bobina" placeholder="Digite o lote da bobina" wire:model="roll_batch" autofocus />
            @error('roll_batch')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror


            <x-input label="Volume da Bobina" placeholder="Digite o volume da bobina" wire:model="roll_vol"
                x-on:focus-roll-vol.window="$el.focus()" />
            @error('roll_vol')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <x-input label="Peso" placeholder="Digite o peso da bobina" wire:model="roll_weight" />
            @error('roll_weight')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <x-button type="submit">Adicionar Bobina</x-button>
        </form>
    </flux:card>
</div>
