@extends('Layout.layout')

@section('title', 'Lista de Insumos')

@section('content')
    <x-card title="Lista de Insumos">
        <x-button href="{{ route('supplies.create') }}" variant="primary" icon="plus">
            Criar Novo Insumo
        </x-button>
    </x-card>

    <x-success-message></x-success-message>

    <livewire:supplies.supply-table />
@endsection
