@extends('Layout.layout')

@section('title', 'Lista de Clientes')

@section('content')
<x-card title="Lista de Clientes">
    <x-slot name="slot">
        <a href="{{ route('clients.create') }}">Criar Novo Cliente</a>
    </x-slot>
</x-card>

<x-sucess-message></x-sucess-message>

<livewire:clients.client-table />
@endsection
