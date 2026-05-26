@extends('Layout.layout')

@section('title', 'Itens de Insumo')

@section('content')
    <x-card title="Itens de Insumo">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <livewire:supply-items.supply-item-table />
@endsection
