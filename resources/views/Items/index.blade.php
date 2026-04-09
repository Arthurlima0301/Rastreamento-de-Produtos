@extends('Layout.layout')

@section('title', 'Items')

@section('content')
    <table class="text-center">
        <thead>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Item</th>
                <th>Unidade de Medida</th>
                <th>Quantidade</th>
                <th>Nota Fiscal</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->insumo->codigo_insumo }}</td>
                    <td>{{ $item->insumo->nome}}</td>
                    <td>{{ $item->numero }}</td>
                    <td>{{ $item->insumo->unidade_medida }}</td>
                    <td>{{ $item->quantidade }}</td>
                    <td>{{ $item->notaFiscal->codigo_nf }}</td>
                    <td>{{ $item->notaFiscal->data_emissao}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection