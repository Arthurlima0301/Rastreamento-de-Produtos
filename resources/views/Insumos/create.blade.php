@extends('Layout.layout')

@section('title', 'Criar Insumo')

@section('content')
<x-card title="Criar Insumo">
    <x-slot name="slot">
        <!-- action slot left intentionally empty -->
    </x-slot>
</x-card>

<x-error-message></x-error-message>

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