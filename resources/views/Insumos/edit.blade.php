@extends('Layout.layout')

@section('title', 'Editar Insumo')

@section('content')
    <x-card title="Editar Insumo">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <x-error-message></x-error-message>

    <x-form action="{{ route('insumos.update', $insumo->id) }}" method="POST" title="Editar">
        @method('PUT')

        <x-input label="Código" name="codigo_insumo" id="codigo_insumo" value="{{ $insumo->codigo_insumo }}" required />
        <x-input label="Nome" name="nome" id="nome" value="{{ $insumo->nome }}" required />
        <x-input label="Unidade de Medida" name="unidade_medida" id="unidade_medida" value="{{ $insumo->unidade_medida }}" required />

    </x-form>
@endsection
