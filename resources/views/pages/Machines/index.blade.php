@extends('Layout.layout')

@section('title', 'Lista de Máquinas')

@section('content')
    <x-card title="Lista de Máquinas">
        <x-button href="{{ route('machines.create') }}" variant="primary" icon="plus">
            Criar Nova Máquina
        </x-button>
    </x-card>

    <x-success-message></x-success-message>
    <x-error-message></x-error-message>

    <livewire:machines.machine-table />
@endsection
