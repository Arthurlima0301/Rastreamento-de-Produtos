<div class="w-full">
    <x-card title="Selecionar Pallets">
        <x-slot name="slot">
            <p><strong>ID Saída: </strong> {{ $dispatch->id }}</p>

            <p><strong>Papel: </strong> {{ $dispatch->itemMaterial->material->paper }}</p>
            <p><strong>Gramatura: </strong> {{ $dispatch->itemMaterial->material->formatted_grammage }}</p>
            <p><strong>Peso Líquido: </strong> {{ $dispatch->itemMaterial->material->formatted_package_net_weight }}</p>

            <x-button href="{{ route('dispatches.supplies', $dispatch)}}">Insumos</x-button>

            <x-button href="{{ route('dispatches.index') }}" variant="primary">Concluído</x-button>
        </x-slot>
    </x-card>


    <x-search-input />
    <section class="flex w-full max-w-full flex-col gap-4 overflow-hidden xl:flex-row">
        <x-table :paginate="$pallets">
            <x-slot:header>
                <flux:table.column align="center">Rótulo</flux:table.column>
                <flux:table.column align="center">Papel</flux:table.column>
                <flux:table.column align="center">Puxada</flux:table.column>
                <flux:table.column align="center">Largura</flux:table.column>
                <flux:table.column align="center">Ordem</flux:table.column>
                <flux:table.column align="center">Item na Ordem</flux:table.column>
                <flux:table.column align="center">Material Bobina</flux:table.column>
                <flux:table.column align="center">Material Folha</flux:table.column>
                <flux:table.column align="center">Lote</flux:table.column>
                <flux:table.column align="center">Peso Líquido</flux:table.column>
                <flux:table.column align="center">Peso Bruto</flux:table.column>
                <flux:table.column align="center">Nota Fiscal</flux:table.column>
                <flux:table.column align="center">Item NF</flux:table.column>
                <flux:table.column align="center">Ações</flux:table.column>
            </x-slot:header>
            <x-slot:rows>
                @foreach ($pallets as $pallet)
                    <flux:table.row wire:key="pallet-{{ $pallet->id }}">
                        <flux:table.cell align="center">{{ $pallet->formatted_label }}</flux:table.cell>
                        <flux:table.cell align="center">
                            <a href="{{ route('item-materials.show', $pallet->itemMaterial) }}" class="hover:underline">
                                {{ $pallet->itemMaterial->material->paper }}
                            </a>
                        </flux:table.cell>
                        <flux:table.cell align="center">{{ $pallet->itemMaterial->material->width }}</flux:table.cell>
                        <flux:table.cell align="center">{{ $pallet->itemMaterial->material->length }}</flux:table.cell>
                        <flux:table.cell align="center">
                            <a href="{{ route('orders.show', $pallet->itemMaterial->material->order) }}"
                                class="hover:underline">
                                {{ $pallet->itemMaterial->material->order->order_code }}
                            </a>
                        </flux:table.cell>
                        <flux:table.cell align="center">{{ $pallet->itemMaterial->material->item_number }}
                        </flux:table.cell>
                        <flux:table.cell align="center">{{ $pallet->itemMaterial->material->shipment_code }}
                        </flux:table.cell>
                        <flux:table.cell align="center">{{ $pallet->itemMaterial->material->expedition_code }}
                        </flux:table.cell>
                        <flux:table.cell align="center">{{ $pallet->itemMaterial->material->return_batch }}
                            <flux:table.cell align="center">{{ $pallet->formatted_package_net_weight }}
                            </flux:table.cell>
                            <flux:table.cell align="center">
                                {{ $pallet->itemMaterial->material->formatted_package_gross_weight }}</flux:table.cell>
                        </flux:table.cell>
                        <flux:table.cell align="center">
                            <a href="{{ route('material-invoices.show', $pallet->itemMaterial->materialInvoice) }}"
                                class="hover:underline">
                                {{ $pallet->itemMaterial->materialInvoice->formatted_invoice_code }}
                            </a>
                        </flux:table.cell>
                        <flux:table.cell align="center">{{ $pallet->itemMaterial->number }}</flux:table.cell>
                        <flux:table.cell align="center">
                            @if (!$pallet->dispatch_id)
                                <x-button wire:click="addPallet({{ $pallet }})">Adicionar</x-button>
                            @else
                                <p>Já Selecionado</p>
                            @endif
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </x-slot:rows>
        </x-table>
    </section>
</div>
