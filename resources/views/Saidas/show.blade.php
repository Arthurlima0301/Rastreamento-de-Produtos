@extends('Layout.Layout')

@section('title', 'Saídas')

@section('content')
    <x-error-message></x-error-message>

    <x-card title="Detalhes da Saída">
        <x-slot name="slot">
            <p><strong>Código:</strong> {{ $saida->id }}</p>
            <p><strong>Data:</strong> {{ $saida->data_saida }}</p>
            <p><strong>Nota Fiscal:</strong> {{ $saida->nota_fiscal ?? 'Não informada' }}</p>
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
            @foreach ($saida->items as $saidaItem)
                <tr>
                    <td class="p-2">{{ $saidaItem->item->numero }}</td>
                    <td class="p-2">{{ $saidaItem->item->notaFiscal->codigo_nf }}</td>
                    <td class="p-2">{{ $saidaItem->item->insumo->codigo_insumo }}</td>
                    <td class="p-2">{{ $saidaItem->item->insumo->nome }}</td>
                    <td class="p-2">{{ $saidaItem->item->insumo->unidade_medida }}</td>
                    <td class="p-2">{{ $saidaItem->quantidade }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
@endsection
