<div class="w-full space-y-4">
    <x-search-input />

    <x-table>
        <x-slot name="header">
            <th class="p-2">ID</th>
            <th class="p-2">Código da Nota</th>
            <th class="p-2">
                Data de Emissão:
                <select name="field"  wire:model.live="parameter">
                    <option value="desc" class="text-mtext">Mais Recentes</option>
                    <option value="asc"  class="text-mtext">Mais Antigas</option>
                </select>
            </th>
            <th class="p-2">Quantidade de Itens</th>
            <th class="p-2">Ações</th>
        </x-slot>

        <x-slot name="rows">
            @foreach ($invoices as $invoice)
                <tr class="hover:bg-hovered">
                    <td class="p-2">{{ $invoice->id }}</td>
                    <td class="p-2">{{ $invoice->formatted_invoice_code }}</td>
                    <td class="p-2">{{ $invoice->issued_at }}</td>
                    <td class="p-2">{{ $invoice->items_count }}</td>
                    <td class="p-2">
                        <a href="{{ route('invoices.show', $invoice->id) }}">Ver</a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>

    {{ $invoices->links(data: ['scrollTo' => false]) }}
</div>
