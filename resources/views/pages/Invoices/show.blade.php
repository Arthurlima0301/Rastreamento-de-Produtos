@extends('Layout.layout')

@section('title', 'Nota Fiscal - Detalhes')

@section('content')
    <x-error-message></x-error-message>

    <x-card title="Detalhes da Nota Fiscal">
        <x-slot name="slot">
            <p><strong>Código:</strong> {{ $invoice->formatted_invoice_code }}</p>
            <p><strong>Data de Emissão:</strong> {{ $invoice->issued_at }}</p>
            <p><strong>Quantidade de Itens:</strong> {{ $invoice->items_count }}</p>
        </x-slot>
    </x-card>

    <x-table>
        <x-slot name="header">
            <th class="p-2">Item</th>
            <th class="p-2">Insumo</th>
            <th class="p-2">Quantidade</th>
            <th class="p-2">Unidade de Medida</th>
        </x-slot>

        <x-slot name="rows">
            @foreach ($invoice->items as $invoiceItem)
                <tr class="hover:bg-hovered">
                    <td class="p-3">{{ $invoiceItem->number }}</td>
                    <td class="p-3">{{ $invoiceItem->supply->name }}</td>
                    <td class="p-3">{{ $invoiceItem->formatted_quantity }}</td>
                    <td class="p-3">{{ $invoiceItem->supply->unit_of_measure}}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
@endsection
