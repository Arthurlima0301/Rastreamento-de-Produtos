@extends('Layout.layout')

@section('title', 'Detalhes do Insumo')

@section('content')
    <x-card title="Detalhes do Insumo">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <p><strong>Código:</strong> {{ $insumo->codigo_insumo }}</p>
    <p><strong>Nome:</strong> {{ $insumo->nome }}</p>
    <p><strong>Unidade de Medida:</strong> {{ $insumo->unidade_medida }}</p>
@endsection