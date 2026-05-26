@extends('Layout.layout')

@section('title', 'Criar Máquina')

@section('content')
    <x-card title="Criar Máquina"></x-card>

    <x-error-message></x-error-message>

    <x-form action="{{ route('machines.store') }}" method="POST" title="Criar Máquina" buttonText="Criar Máquina">
        <x-input name="name" label="Nome" type="text" value="" required></x-input>
        <x-input name="acronym" label="Sigla" type="text" value="" maxlength="1" required></x-input>
    </x-form>
@endsection
