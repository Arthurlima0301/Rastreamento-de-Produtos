@extends('Layout.layout')

@section('title', 'Saidas')

@section('content')
    <x-card title="Saidas">
        <x-slot name="slot">
            <a href="{{ route('saidas.create') }}">Criar Saída</a>
        </x-slot>
    </x-card>

    <x-sucess-message></x-sucess-message>

    <x-table>
        <x-slot name="header">
            <th class="p-2">ID</th>
            <th class="p-2">Data</th>
            <th class="p-2">Nota Fiscal</th>
        </x-slot>

        <x-slot name="rows">
            @foreach ($saidas as $saida)
                <tr>
                    <td class="p-2"><a href="{{ route('saidas.show', $saida->id) }}">{{ $saida->id }}</a></td>
                    <td class="p-2">{{ $saida->data_saida }}</td>
                    <td class="p-2">{{ $saida->nota_fiscal ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
@endsection
