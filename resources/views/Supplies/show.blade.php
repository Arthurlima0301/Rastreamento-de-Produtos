@extends('Layout.layout')

@section('title', 'Detalhes do Insumo')

@section('content')
    <x-card title="Detalhes do Insumo">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <p><strong>Código:</strong> {{ $supply->supply_code }}</p>
    <p><strong>Nome:</strong> {{ $supply->name }}</p>
    <p><strong>Unidade de Medida:</strong> {{ $supply->unit_of_measure }}</p>
@endsection
