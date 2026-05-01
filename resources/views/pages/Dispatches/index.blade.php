@extends('Layout.layout')

@section('title', 'Saidas')

@section('content')
    <x-card title="Saidas">
        <x-slot name="slot">
            <a href="{{ route('dispatches.create') }}">Criar Saída</a>
        </x-slot>
    </x-card>

    <x-sucess-message></x-sucess-message>

    <livewire:dispatches.dispatch-table />
@endsection
