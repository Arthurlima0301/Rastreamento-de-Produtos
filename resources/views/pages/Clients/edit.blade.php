@extends('Layout.layout')

@section('title', 'Editar Cliente')

@section('content')
    <x-card title="Editar Cliente">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <x-error-message></x-error-message>

    <x-form action="{{ route('clients.update', $client->id) }}" method="POST" title="Editar">
        @method('PUT')

        <x-input label="Nome" name="name" id="name" value="{{ $client->name }}" required />
    </x-form>
@endsection
