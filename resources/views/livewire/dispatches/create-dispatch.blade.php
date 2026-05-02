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
                    <tr>
                        <td class="p-2">{{ $item->supply->supply_code }}</td>
                        <td class="p-2">{{ $item->supply->name }}</td>
                        <td class="p-2">{{ $item->number }}</td>
                        <td class="p-2">{{ $item->supply->unit_of_measure }}</td>
                        <td class="p-2">{{ $item->quantity }}</td>
                        <td class="p-2">{{ $item->invoice->invoice_code }}</td>
                        <td class="p-2">{{ $item->invoice->issued_at }}</td>
                        <td class="p-2">{{ $item->balance }}</td>
                        <td class="p-2">

                            <button
                                class="w-full text-muted p-2 cursor-pointer rounded {{ isset($selectedItems[$item->id]) ? 'bg-secondary' : 'bg-primary' }}"
                                wire:click="selectItem({{ $item->id }})">
                                {{ isset($selectedItems[$item->id]) ? 'Selecionado' : 'Selecionar' }}
                            </button>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>

        {{ $items->links(data: ['scrollTo' => false]) }}
    </div>

    <x-selected-items-list :selectedItems="$selectedItems" />
</div>
