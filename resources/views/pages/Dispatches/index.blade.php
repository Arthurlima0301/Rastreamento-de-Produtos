@extends('Layout.layout')

@section('title', 'Saidas')

@section('content')
    <x-card title="Saidas">
        <x-slot name="slot">
            <x-button href="{{ route('dispatches.create') }}" variant="primary" icon="plus">
                Criar Nova Saída
            </x-button>
        </x-slot>
    </x-card>

    <x-success-message></x-success-message>

    <livewire:dispatches.dispatch-table />
@endsection
