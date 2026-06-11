<div>
    <x-search-input />


    <x-table :paginate="$rolls">
        <x-slot:header>
            <flux:table.column align="center">Item da NF</flux:table.column>
            <flux:table.column align="center">Rótulo</flux:table.column>
            <flux:table.column align="center">Peso da Bobina</flux:table.column>
            <flux:table.column align="center">Status</flux:table.column>
            <flux:table.column align="center">Data</flux:table.column>
            <flux:table.column align="center">NF Entrada</flux:table.column>
            <flux:table.column align="center">Papel</flux:table.column>
            <flux:table.column align="center">Cod. Envio</flux:table.column>
            <flux:table.column align="center">Gramatura</flux:table.column>
            <flux:table.column align="center">Largura</flux:table.column>
            <flux:table.column align="center">Comprimento</flux:table.column>
            <flux:table.column align="center">Folhas</flux:table.column>
            <flux:table.column align="center">Cod. Expedição</flux:table.column>
            <flux:table.column align="center">Lote de Retorno</flux:table.column>
            <flux:table.column align="center">Defeito</flux:table.column>
            <flux:table.column align="center">Peso do Defeito</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($rolls as $roll)
                <flux:table.row wire:key="roll-{{ $roll->id }}">
                    <flux:table.cell align="center">{{ $roll->itemMaterial->number }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->label }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->formatted_weight }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->status }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->materialInvoice->formatted_issued_at }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <a href="{{ route('material-invoices.show', $roll->itemMaterial->materialInvoice) }}" class="hover:underline">
                            {{ $roll->itemMaterial->materialInvoice->formatted_invoice_code }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->paper }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->expedition_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->formatted_grammage }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->width }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->length }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->packages }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->expedition_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->itemMaterial->material->return_batch }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->defect ?? '-' }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $roll->formatted_defect_weight ?? '-' }}</flux:table.cell>

                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
