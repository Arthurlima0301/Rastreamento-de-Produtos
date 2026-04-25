@extends('Layout.layout')

@section('title', 'Items')

@section('content')
    <x-card title="Items">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

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
        </x-slot>

        <x-slot name="rows">
            @foreach($items as $item)
                <tr>
                    <td class="p-2">{{ $item->supply->supply_code }}</td>
                    <td class="p-2">{{ $item->supply->name }}</td>
                    <td class="p-2">{{ $item->number }}</td>
                    <td class="p-2">{{ $item->supply->unit_of_measure }}</td>
                    <td class="p-2">{{ $item->quantity }}</td>
                    <td class="p-2">{{ $item->invoice->invoice_code }}</td>
                    <td class="p-2">{{ $item->invoice->issued_at }}</td>
                    <td class="p-2">{{ $item->balance }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
@endsection
