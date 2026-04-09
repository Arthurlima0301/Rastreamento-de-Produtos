@extends('Layout.layout')

@section('title', 'Criar Insumo')

@section('content')
<h1>Criar Insumo</h1>

@if ($errors->any())
<p>{{ $errors->first() }}</p>
@endif

<form action="{{ route('insumos.store') }}" method="POST">
    @csrf
    <div>
        <label for="codigo_insumo">Código:</label>
        <input type="text" name="codigo_insumo" id="codigo_insumo" required>
    </div>
    <div>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>
    </div>
    <div>
        <label for="unidade_medida">Unidade de Medida:</label>
        <input type="text" name="unidade_medida" id="unidade_medida" required>
    </div>
    <button type="submit">Criar Insumo</button>
</form>
@endsection