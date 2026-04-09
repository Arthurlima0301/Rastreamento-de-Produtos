@extends('Layout.layout')

@section('title', 'Detalhes do Insumo')

@section('content')
    <h1>Detalhes do Insumo</h1>
    <p><strong>Código:</strong> {{ $insumo->codigo_insumo }}</p>
    <p><strong>Nome:</strong> {{ $insumo->nome }}</p>
    <p><strong>Unidade de Medida:</strong> {{ $insumo->unidade_medida }}</p>
@endsection