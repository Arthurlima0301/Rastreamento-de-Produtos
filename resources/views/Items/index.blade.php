@extends('Layout.layout')

@section('title', 'Items')

@section('content')
    <x-card title="Items">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <livewire:items.item-table />
@endsection
