@extends('Layout.layout')

@section('title', 'Items')

@section('content')
    <h1>Items</h1>

    <x-table>
        <x-slot name="header">
            <th class="p-2">Código</th>
            <th class="p-2">Descrição</th>
            <th class="p-2">Item</th>
            <th class="p-2">Unidade de Medida</th>
            <th class="p-2">Quantidade</th>
            <th class="p-2">Nota Fiscal</th>
            <th class="p-2">Data</th>
        </x-slot>

        <x-slot name="rows">
            @foreach($items as $item)
                <tr>
                    <td class="p-2">{{ $item->insumo->codigo_insumo }}</td>
                    <td class="p-2">{{ $item->insumo->nome}}</td>
                    <td class="p-2">{{ $item->numero }}</td>
                    <td class="p-2">{{ $item->insumo->unidade_medida }}</td>
                    <td class="p-2">{{ $item->quantidade }}</td>
                    <td class="p-2">{{ $item->notaFiscal->codigo_nf }}</td>
                    <td class="p-2">{{ $item->notaFiscal->data_emissao}}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
@endsection