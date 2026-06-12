<div class="w-full">
    <x-card title="Adicionar Materiais">
        <x-slot name="slot">
            <p><strong>Código:</strong> {{ $order->order_code }}</p>
            <p><strong>Cliente:</strong> {{ $order->client->name }}</p>
        </x-slot>
    </x-card>



    <flux:card  >

        <div class="flex items-center justify-between gap-6 mb-4">
            <div class="flex items-center gap-4">
                <flux:heading size="lg">Adicionar Materiais à Ordem de Corte</flux:heading>
                <x-button type="button" wire:click="addMaterialInput" variant="primary" size="sm" icon="plus" />
            </div>

            <x-button type="button" wire:click="clearMaterialInput" variant="ghost" size="sm">
                Limpar Todos os Campos
            </x-button>
        </div>

        <form wire:submit.prevent="saveAll">
            @if ($errors->any())
                <p class="text-red-500 text-sm my-4">
                    {{ $errors->first() }}
                </p>
            @endif


            <div class="min-w-auto overflow-x-auto">
                <div
                    class="grid grid-cols-[4rem_7rem_4rem_5rem_8rem_5rem_6rem_8rem_10rem_7rem_5rem_7rem_8rem_2.5rem] gap-2 mb-2 text-xs">
                    <span>Item</span>
                    <span>Cód. Envio</span>
                    <span>Rolo</span>
                    <span>Largura</span>
                    <span>Comprimento</span>
                    <span>Folhas</span>
                    <span>Gramatura</span>
                    <span>Cód. Expedicao</span>
                    <span>Papel</span>
                    <span>Lote de Retorno</span>
                    <span>Pacotes</span>
                    <span>Peso Líquido P.</span>
                    <span>Peso Bruto P.</span>
                    <span></span>
                </div>

                @for ($i = 0; $i < $inputMaterial; $i++)
                    <div class="grid grid-cols-[4rem_7rem_4rem_5rem_8rem_5rem_6rem_8rem_10rem_7rem_5rem_7rem_8rem_2.5rem] items-start gap-2 mb-4"
                        wire:key="materials-{{ $i }}">
                        <x-input wire:model="materials.{{ $i }}.item_number" placeholder="Item" />
                        <x-input wire:model="materials.{{ $i }}.shipment_code" placeholder="Cod. Envio" />
                        <x-input wire:model="materials.{{ $i }}.roll" placeholder="Rolo" />
                        <x-input wire:model="materials.{{ $i }}.width" placeholder="Largura" />
                        <x-input wire:model="materials.{{ $i }}.length" placeholder="Comprimento" />
                        <x-input wire:model="materials.{{ $i }}.sheets" placeholder="Folhas" />
                        <x-input wire:model="materials.{{ $i }}.grammage" placeholder="Gramatura" />
                        <x-input wire:model="materials.{{ $i }}.expedition_code" placeholder="Cod. Expedicao" />
                        <x-input wire:model="materials.{{ $i }}.paper" placeholder="Papel" />
                        <x-input wire:model="materials.{{ $i }}.return_batch" placeholder="Lote de Retorno" />
                        <x-input wire:model="materials.{{ $i }}.packages" placeholder="Pacotes" />
                        <x-input wire:model="materials.{{ $i }}.package_net_weight" placeholder="Peso Líquido P." />
                        <x-input wire:model="materials.{{ $i }}.package_gross_weight" placeholder="Peso Bruto P." />

                        <x-button type="button" wire:click="removeMaterialInput({{ $i }})" variant="ghost" size="sm" icon="x-mark" />
                    </div>
                @endfor
                <x-button type="submit" variant="primary" class="w-full mt-4">
                    Salvar Materiais
                </x-button>
            </div>
        </form>
    </flux:card>
</div>
