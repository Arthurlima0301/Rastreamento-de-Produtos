@extends('Layout.layout')

@section('title', 'Saídas')

@section('content')
    <x-error-message></x-error-message>

    <x-card title="Detalhes da Saída">
        <x-slot name="slot">
            <p><strong>Código:</strong> {{ $dispatch->id }}</p>
            <p><strong>Data:</strong> {{ $dispatch->dispatched_at }}</p>
            <p><strong>Nota Fiscal:</strong> {{ $dispatch->invoice ?? 'Não informada' }}</p>
        </x-slot>
    </x-card>

    <x-table>
        <x-slot name="header">
            <th class="p-2">Número do Item  </th>
            <th class="p-2">Nota Fiscal Origem</th>
            <th class="p-2">Código do Insumo</th>
            <th class="p-2">Nome do Insumo</th>
            <th class="p-2">Unidade de Medida</th>
            <th class="p-2">Quantidade</th>
        </x-slot>

        <x-slot name="rows">
            @foreach ($dispatch->items as $dispatchItem)
                <tr>
                    <td class="p-2">{{ $dispatchItem->item->number }}</td>
                    <td class="p-2">{{ $dispatchItem->item->invoice->invoice_code }}</td>
                    <td class="p-2">{{ $dispatchItem->item->supply->supply_code }}</td>
                    <td class="p-2">{{ $dispatchItem->item->supply->name }}</td>
                    <td class="p-2">{{ $dispatchItem->item->supply->unit_of_measure }}</td>
                    <td class="p-2">{{ $dispatchItem->quantity }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
@endsection
