@extends('Layout.layout')

@section('title', 'Itens de Material')

@section('content')
    <x-card title="Itens de Material">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <livewire:material-items.material-item-table />
@endsection
