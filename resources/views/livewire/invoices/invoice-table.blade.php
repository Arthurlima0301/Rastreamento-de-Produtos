<div class="w-full space-y-4">
    <x-search-input />

    <x-table>
        <x-slot name="header">
            <th class="p-2">ID</th>
            <th class="p-2">Código NF</th>
            <th class="p-2">Data de Emissão</th>
        </x-slot>

        <x-slot name="rows">
            @foreach ($invoices as $invoice)
                <tr class="hover:bg-hovered">
                    <td class="p-2">{{ $invoice->id }}</td>
                    <td class="p-2">{{ $invoice->formatted_invoice_code }}</td>
                    <td class="p-2">{{ $invoice->issued_at }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>

    {{ $invoices->links(data: ['scrollTo' => false]) }}
</div>
