<div class="w-full">
    <x-card title="Editar Material">
        <x-slot>
        </x-slot>
    </x-card>

    <flux:card>
        <flux:heading size="xl" class="mb-3">Editar Material</flux:heading>
        
        <div class="flex flex-col gap-2 mb-6">

            <p>Ordem de Corte</p>
            <x-select class="w-[400px]" wire:model="form.order_id"> 
                <option>Escolha a Ordem</option>
                @foreach ($orders as $order)
                    <option value="{{ $order->id }}">{{$order->order_code}}</option>
                @endforeach
            </x-select>
        </div>

        <form wire:submit.prevent="saveEdit">
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

                <div
                    class="grid grid-cols-[4rem_7rem_4rem_5rem_8rem_5rem_6rem_8rem_10rem_7rem_5rem_7rem_8rem_2.5rem] items-start gap-2 mb-4">
                    <x-input wire:model="form.item_number" placeholder="Item" />
                    <x-input wire:model="form.shipment_code" placeholder="Cod. Envio" />
                    <x-input wire:model="form.roll" placeholder="Rolo" />
                    <x-input wire:model="form.width" placeholder="Largura" />
                    <x-input wire:model="form.length" placeholder="Comprimento" />
                    <x-input wire:model="form.sheets" placeholder="Folhas" />
                    <x-input wire:model="form.grammage" placeholder="Gramatura" />
                    <x-input wire:model="form.expedition_code" placeholder="Cod. Expedicao" />
                    <x-input wire:model="form.paper" placeholder="Papel" />
                    <x-input wire:model="form.return_batch" placeholder="Lote de Retorno" />
                    <x-input wire:model="form.packages" placeholder="Pacotes" />
                    <x-input wire:model="form.package_net_weight" placeholder="Peso Líquido P." />
                    <x-input wire:model="form.package_gross_weight" placeholder="Peso Bruto P." />
                </div>

                <x-button type="submit" variant="primary" class="w-full mt-4">
                    Salvar Alterações
                </x-button>
            </div>
        </form>
    </flux:card>
</div>
