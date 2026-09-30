<div>
    <x-success-message />
    <x-error-message />
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
                    </flux:table.row>
                @endforeach
            </x-slot:rows>
        </x-table>
    </section>
</div>
