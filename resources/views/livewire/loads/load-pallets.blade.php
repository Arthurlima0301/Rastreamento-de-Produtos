<div>
    <x-search-input />

    <x-table :paginate="$pallets">

        <x-slot name="header">
            <flux:table.column align="center">Rótulo</flux:table.column>
            <flux:table.column align="center">Papel</flux:table.column>
            <flux:table.column align="center">Nota Fiscal</flux:table.column>
            <flux:table.column align="center">Nº do Item </flux:table.column>
            <flux:table.column align="center">Lote de Retorno </flux:table.column>
            <flux:table.column align="center">Peso Líquido P.</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot>

        <x-slot name="rows">
            @foreach ($pallets as $pallet)
                <flux:table.row wire:key="pallet-{{ $pallet->id }}">
                    <flux:table.cell align="center">{{ $pallet->formatted_label }}</flux:table.cell>
                    <flux:table.cell align="center">
                        {{ $pallet->itemMaterial->material->paper }}
                    </flux:table.cell>
                    <flux:table.cell align="center">
                        <a href="{{ route('material-invoices.show', $pallet->itemMaterial->materialInvoice) }}" class="hover:underline">
                            {{ $pallet->itemMaterial->materialInvoice->formatted_invoice_code }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $pallet->itemMaterial->number }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $pallet->itemMaterial->material->return_batch }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $pallet->formatted_package_net_weight }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <flux:button icon="pencil" variant="ghost"  href="{{ route('pallets.edit', $pallet->id) }}" />
                        <flux:button icon="trash" variant="primary" color="red" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot>
    </x-table>
</div>
