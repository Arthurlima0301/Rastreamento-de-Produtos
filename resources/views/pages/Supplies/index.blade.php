@extends('Layout.layout')

@section('title', 'Lista de Insumos')

@section('content')
<x-card title="Lista de Insumos">
    <x-slot name="slot">
        <a href="{{ route('supplies.create') }}">Criar Novo Insumo</a>
    </x-slot>
</x-card>

<x-sucess-message></x-sucess-message>

<livewire:supplies.supply-table />
@endsection
