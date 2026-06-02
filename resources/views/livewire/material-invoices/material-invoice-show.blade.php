<div class="w-full">
    <x-error-message />

    <x-card title="Detalhes da Nota Fiscal de Material">
        <x-slot name="slot">
            <p><strong>Codigo:</strong> {{ $materialInvoice->formatted_invoice_code }}</p>
            <p><strong>Data de Emissao:</strong> {{ $materialInvoice->formatted_issued_at }}</p>
            <p><strong>Quantidade de Itens:</strong> {{ $materialInvoice->item_materials_count }}</p>
        </x-slot>
    </x-card>

    <x-table>
        <x-slot:header>
            <flux:table.column align="center">Item</flux:table.column>
            <flux:table.column align="center">Ordem</flux:table.column>
            <flux:table.column align="center">Cliente</flux:table.column>
            <flux:table.column align="center">Cod. Envio</flux:table.column>
            <flux:table.column align="center">Rolo</flux:table.column>
            <flux:table.column align="center">Largura</flux:table.column>
            <flux:table.column align="center">Comprimento</flux:table.column>
            <flux:table.column align="center">Folhas</flux:table.column>
            <flux:table.column align="center">Gramatura</flux:table.column>
            <flux:table.column align="center">Cod. Expedicao</flux:table.column>
            <flux:table.column align="center">Papel</flux:table.column>
            <flux:table.column align="center">Lote Retorno</flux:table.column>
            <flux:table.column align="center">Pacotes</flux:table.column>
            <flux:table.column align="center">Peso Liq. P</flux:table.column>
            <flux:table.column align="center">Peso Bruto P</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($materialInvoice->itemMaterials as $itemMaterial)
                <flux:table.row wire:key="item-material-{{ $itemMaterial->id }}">
                    @php($material = $itemMaterial->material)

                    <flux:table.cell align="center">{{ $material->item_number }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->order->order_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->order->client->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->shipment_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->roll }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->width }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->length }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->sheets }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->formatted_grammage }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->expedition_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->paper }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->return_batch }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->packages }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->formatted_package_net_weight }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->formatted_package_gross_weight }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
