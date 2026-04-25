@extends('Layout.layout')

@section('title', 'Editar Insumo')

@section('content')
    <x-card title="Editar Insumo">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <x-error-message></x-error-message>

    <x-form action="{{ route('supplies.update', $supply->id) }}" method="POST" title="Editar">
        @method('PUT')

        <x-input label="Código" name="supply_code" id="supply_code" value="{{ $supply->supply_code }}" required />
        <x-input label="Nome" name="name" id="name" value="{{ $supply->name }}" required />
        <x-input label="Unidade de Medida" name="unit_of_measure" id="unit_of_measure" value="{{ $supply->unit_of_measure }}" required />

    </x-form>
@endsection
