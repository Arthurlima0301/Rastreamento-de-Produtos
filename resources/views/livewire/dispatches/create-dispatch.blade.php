<div class="flex w-full">
    <div>
        <x-search-input />

        <x-table>
            <x-slot name="header">
                <th class="p-2">Código</th>
                <th class="p-2">Descrição</th>
                <th class="p-2">Item</th>
                <th class="p-2">Unidade de Medida</th>
                <th class="p-2">Quantidade</th>
                <th class="p-2">Nota Fiscal</th>
                <th class="p-2">Data</th>
                <th class="p-2">Saldo</th>
                <th class="p-2">Ações</th>
            </x-slot>

            <x-slot name="rows">

                @foreach ($items as $item)
                    <tr class="hover:bg-hovered">
                        <td class="p-2">{{ $item->supply->supply_code }}</td>
                        <td class="p-2">{{ $item->supply->name }}</td>
                        <td class="p-2">{{ $item->number }}</td>
                        <td class="p-2">{{ $item->supply->unit_of_measure }}</td>
                        <td class="p-2">{{ $item->formatted_quantity }}</td>
                        <td class="p-2">{{ $item->invoice->formatted_invoice_code }}</td>
                        <td class="p-2">{{ $item->invoice->issued_at }}</td>
                        <td class="p-2">{{ $item->formatted_balance }}</td>
                        <td class="p-2">

                            <x-button
                                variant="primary"
                                color="{{ isset($selectedItems[$item->id]) ? 'red' : 'blue' }}"
                                class="w-full"
                                wire:click="selectItem({{ $item->id }})">

                                {{ isset($selectedItems[$item->id]) ? 'Remover' : 'Selecionar' }}
                            </x-button>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>

        {{ $items->links(data: ['scrollTo' => false]) }}
    </div>

    <x-selected-items-list :selectedItems="$selectedItems" />
</div>
