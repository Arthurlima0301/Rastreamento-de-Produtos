@extends('Layout.layout')

@section('title', 'Criar Insumo')

@section('content')
<x-card title="Criar Insumo"></x-card>

<x-error-message></x-error-message>

<x-form action="{{ route('insumos.store') }}" method="POST" title="Criar Insumo" buttonText="Criar Insumo">

    <x-input name="codigo_insumo" label="Código" type="text" required></x-input>
    <x-input name="nome" label="Nome" type="text" required></x-input>
    <x-input name="unidade_medida" label="Unidade de Medida" type="text" required></x-input>
</x-form>

@endsection