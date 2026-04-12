@extends('Layout.layout')

@section('title', 'Lista de Insumos')

@section('content')
<x-card title="Lista de Insumos">
    <x-slot name="slot">
        <a href="{{ route('insumos.create') }}">Criar Novo Insumo</a>
    </x-slot>
</x-card>

<x-sucess-message></x-sucess-message>

<x-table>
    <x-slot name="header">
            <th class="p-2">Nome</th>
        <th class="p-2">Código</th>
        <th class="p-2">Unidade de Medida</th>
        <th class="p-2">Ações</th>
    </x-slot>

    <x-slot name="rows">
        @foreach ($insumos as $insumo)
            <tr>
                <td class="p-2">{{ $insumo->nome }}</td>
                <td class="p-2">{{ $insumo->codigo_insumo }}</td>
                <td class="p-2">{{ $insumo->unidade_medida }}</td>
                <td class="p-2">
                    <a href="{{ route('insumos.show', $insumo->id) }}">Ver</a>
                    <a href="{{ route('insumos.edit', $insumo->id) }}">Editar</a>
                    <form action="{{ route('insumos.destroy', $insumo->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-table>
@endsection