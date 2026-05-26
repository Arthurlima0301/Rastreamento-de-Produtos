@extends('Layout.layout')

@section('title', 'Ordem de Corte')

@section('content')
    <x-card title="Ordens de Corte">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <livewire:orders.order-table />
@endsection
