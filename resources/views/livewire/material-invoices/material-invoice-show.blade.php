<div class="w-full">
    <x-error-message />

    <x-card title="Detalhes de Nota Fiscal de Material">
        <x-slot name="slot">
            <p><strong>Código:</strong> {{ $materialInvoice->formatted_invoice_code }}</p>
            <p><strong>Data de Emissão:</strong> {{ $materialInvoice->formatted_issued_at }}</p>
            <p><strong>Quantidade de Itens:</strong> {{ $materialInvoice->item_materials_count }}</p>
        </x-slot>
    </x-card>

    <x-table>
        <x-slot:header>
            <flux:table.column align="center">Nº do Item</flux:table.column>
            <flux:table.column align="center">Papel</flux:table.column>
            <flux:table.column align="center">Gramatura</flux:table.column>
            <flux:table.column align="center">Rolo</flux:table.column>
            <flux:table.column align="center">Cód. Envio</flux:table.column>
            <flux:table.column align="center">Cód. Expedição</flux:table.column>
            <flux:table.column align="center">Lote de Retorno</flux:table.column>
            <flux:table.column align="center">Peso</flux:table.column>
            <flux:table.column align="center">Peso Líquido P.</flux:table.column>
            <flux:table.column align="center">Peso Bruto P.</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($materialInvoice->itemMaterials as $itemMaterial)
                <flux:table.row wire:key="item-material-{{ $itemMaterial->id }}">
                    <flux:table.cell align="center">{{ $itemMaterial->number }}</flux:table.cell>
                    <flux:table.cell align="center">  
                        <a href="{{ route('item-materials.show', $itemMaterial) }}" class="hover:underline">
                            {{ $itemMaterial->material->paper }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->formatted_grammage }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->roll }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->shipment_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->expedition_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->return_batch }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->formatted_total_weight }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->formatted_package_net_weight }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $itemMaterial->material->formatted_package_gross_weight }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <x-button href="{{ route('item-materials.show', $itemMaterial) }}" icon="arrow-up-right"/>
                        <x-button href="{{ route('item-materials.edit', $itemMaterial) }}" icon="arrow-path-rounded-square"/>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
