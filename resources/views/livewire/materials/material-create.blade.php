<div class="w-full">
    <x-card title="Adicionar Materiais">
        <x-slot name="slot">
            <div class="flex items-center gap-4">
                <p><strong>Codigo:</strong> {{ $order->order_code }}</p>
                <p><strong>Cliente:</strong> {{ $order->client->name }}</p>
            </div>
        </x-slot>
    </x-card>



    <flux:card class=" overflow-y-auto">

        <div class="flex items-center justify-between gap-6 mb-4">
            <div class="flex items-center gap-4">
                <flux:heading size="lg">Adicionar Materiais à Ordem de Corte</flux:heading>
                <x-button type="button" wire:click="addMaterialInput" variant="primary" size="sm" icon="plus" />
            </div>

            <x-button type="button" wire:click="clearMaterialInput" variant="ghost" size="sm">
                Limpar Todos os Campos
            </x-button>
        </div>

        <form wire:submit.prevent="saveAll" class="h-[65vh]">
            @if ($errors->any())
                <p class="text-red-500 text-sm my-4">
                    {{ $errors->first() }}
                </p>
            @endif

            @for ($i = 0; $i < $inputMaterial; $i++)
                <div class="flex items-center gap-2 mb-4" wire:key="materials-{{ $i }}">
                    <x-input wire:model="materials.{{ $i }}.item_number" />
                    <x-input wire:model="materials.{{ $i }}.shipment_code" />
                    <x-input wire:model="materials.{{ $i }}.roll" />
                    <x-input wire:model="materials.{{ $i }}.width" />
                    <x-input wire:model="materials.{{ $i }}.length" />
                    <x-input wire:model="materials.{{ $i }}.sheets" />
                    <x-input wire:model="materials.{{ $i }}.grammage" />
                    <x-input wire:model="materials.{{ $i }}.expedition_code" />
                    <x-input wire:model="materials.{{ $i }}.paper" />
                    <x-input wire:model="materials.{{ $i }}.return_batch" />
                    <x-input wire:model="materials.{{ $i }}.packages" />
                    <x-input wire:model="materials.{{ $i }}.package_net_weight" />
                    <x-input wire:model="materials.{{ $i }}.package_gross_weight" />

                    <x-button type="button" wire:click="removeMaterialInput({{ $i }})" variant="ghost"
                        size="sm" icon="x-mark" />
                </div>
            @endfor

            <x-button type="submit" variant="primary" class="w-full mt-4">
                Salvar Materiais
            </x-button>
        </form>
    </flux:card>
</div>
