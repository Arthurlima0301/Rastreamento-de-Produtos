@extends('Layout.layout')

@section('title', 'Editar Insumo')

@section('content')
    <h1>Editar Insumo</h1>
    
    @if ($errors->any())
        <p>{{ $errors->first() }}</p>
    @endif

    <form action="{{ route('insumos.update', $insumo->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="{{ $insumo->nome }}" required>
        </div>
        <div>
            <label for="codigo_insumo">Código:</label>
            <input type="text" name="codigo_insumo" id="codigo_insumo" value="{{ $insumo->codigo_insumo }}" required>
        </div>
        <div>
            <label for="unidade_medida">Unidade de Medida:</label>
            <input type="text" name="unidade_medida" id="unidade_medida" value="{{ $insumo->unidade_medida }}"
                required>
        </div>
        <button type="submit">Atualizar Insumo</button>
    </form>
@endsection
