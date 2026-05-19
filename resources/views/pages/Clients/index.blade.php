@extends('Layout.layout')

@section('title', 'Lista de Clientes')

@section('content')
<x-card title="Lista de Clientes">
    <x-slot name="slot">
        <x-button href="{{ route('clients.create') }}" variant="primary" icon="plus">
            Criar Novo Cliente
        </x-button>
    </x-slot>
</x-card>

<x-success-message></x-success-message>

<livewire:clients.client-table />
@endsection
