@extends('Layout.layout')

@section('title', 'Lista de Insumos')

@section('content')
<h1>Lista de Insumos</h1>

@if (session('success'))
<p>{{ session('success') }}</p>
@endif


<a href="{{ route('insumos.create') }}">Criar Novo Insumo</a>
<table style="text-align: center;">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Código</th>
            <th>Unidade de Medida</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($insumos as $insumo)
        <tr>
            <td>{{ $insumo->nome }}</td>
            <td>{{ $insumo->codigo_insumo }}</td>
            <td>{{ $insumo->unidade_medida }}</td>
            <td>
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
    </tbody>
</table>
@endsection