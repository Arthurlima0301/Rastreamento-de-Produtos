@extends('Layout.layout')

@section('title', 'Saidas')

@section('content')
    <x-card title="Saidas">
        <x-slot name="slot">
            <a href="{{ route('dispatches.create') }}">Criar Saída</a>
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
            @foreach ($dispatches as $dispatch)
                <tr>
                    <td class="p-2"><a href="{{ route('dispatches.show', $dispatch->id) }}">{{ $dispatch->id }}</a></td>
                    <td class="p-2">{{ $dispatch->dispatched_at }}</td>
                    <td class="p-2">{{ $dispatch->invoice ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
@endsection
