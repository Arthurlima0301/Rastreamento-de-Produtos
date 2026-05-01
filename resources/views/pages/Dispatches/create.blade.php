@extends('Layout.layout')

@section('title', 'Saídas')

@section('content')
    <x-error-message></x-error-message>

    <x-card title="Criar Saída" />
    <livewire:dispatches.create-dispatch />
@endsection
