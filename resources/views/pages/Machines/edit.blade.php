@extends('Layout.layout')

@section('title', 'Editar Máquina')

@section('content')
    <x-card title="Editar Máquina">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <x-error-message></x-error-message>

    <x-form action="{{ route('machines.update', $machine->id) }}" method="POST" title="Editar Máquina"
        buttonText="Salvar Máquina">
        @method('PUT')

        <x-input label="Nome" name="name" id="name" value="{{ $machine->name }}" required />
        <x-input label="Sigla" name="acronym" id="acronym" value="{{ $machine->acronym }}" maxlength="1" required />
    </x-form>
@endsection
