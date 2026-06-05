<div class="w-full">
    <x-card title="Adicionar Bobinas">
        <x-slot name="slot">
            <div class="flex items-center gap-3">
                <p><strong>NF: </strong> {{ $itemMaterial->materialInvoice->formatted_invoice_code }}</p>
                <p><strong>Item: </strong> {{ $itemMaterial->number }}</p>
                <p><strong>Papel: </strong> {{ $itemMaterial->material->paper }}</p>
                <p><strong>Gramatura: </strong> {{ $itemMaterial->material->formatted_grammage }}</p>
                <p><strong>Rolo: </strong> {{ $itemMaterial->material->roll }}</p>
            </div>
        </x-slot>
    </x-card>

    <x-success-message />

    <flux:card>
        <form wire:submit.prevent="save" class="flex flex-col gap-4 mt-4">
            <x-input label="Código da Bobina" placeholder="Digite o código da bobina" wire:model="roll_label" tabindex="1"  autofocus />
            @error('roll_label')
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
