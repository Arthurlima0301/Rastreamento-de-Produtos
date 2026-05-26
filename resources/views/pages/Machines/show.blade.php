@extends('Layout.layout')

@section('title', 'Detalhes da Máquina')

@section('content')
    <x-card title="Detalhes da Máquina">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <p><strong>Nome:</strong> {{ $machine->name }}</p>
    <p><strong>Sigla:</strong> {{ $machine->acronym }}</p>
@endsection
