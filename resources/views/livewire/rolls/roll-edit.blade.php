<div class="w-full">
    <x-card title="Editar Bobina">
        <x-slot name="slot">
            <div class="flex items-center gap-3">
                <p><strong>NF: </strong> {{ $roll->itemMaterial->materialInvoice->formatted_invoice_code }}</p>
                <p><strong>Item: </strong> {{ $roll->itemMaterial->number }}</p>
                <p><strong>Papel: </strong> {{ $roll->itemMaterial->material->paper }}</p>
                <p><strong>Gramatura: </strong> {{ $roll->itemMaterial->material->formatted_grammage }}</p>
                <p><strong>Rolo: </strong> {{ $roll->itemMaterial->material->roll }}</p>
            </div>
        </x-slot>
    </x-card>

    <flux:card>
        <form wire:submit="save" class="flex flex-col gap-4 mt-4">
            
            <x-input label="Rótulo da Bobina" placeholder="Digite o rótulo da bobina" wire:model="roll_label" autofocus />
            @error('roll_label')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror


            <x-input label="Peso" placeholder="Digite o peso da bobina" wire:model="roll_weight" />
            @error('roll_weight')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <x-input label="Defeito" placeholder="Digite o defeito da bobina" wire:model="roll_defect" />
            @error('roll_defect')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <x-input label="Peso do Defeito" placeholder="Digite o peso do defeito da bobina" wire:model="roll_defect_weight" />
            @error('roll_defect_weight')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <x-button type="submit" variant="primary">Salvar</x-button>
        </form>
    </flux:card>
</div>
