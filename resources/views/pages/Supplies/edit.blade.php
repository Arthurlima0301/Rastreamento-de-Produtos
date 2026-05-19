@extends('Layout.layout')

@section('title', 'Editar Insumo')

@section('content')
    <x-card title="Editar Insumo">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <x-error-message></x-error-message>

    <x-form action="{{ route('supplies.update', $supply->id) }}" method="POST" title="Editar">
        @method('PUT')

        <x-input label="Código" name="supply_code" id="supply_code" value="{{ $supply->supply_code }}" required />
        <x-input label="Nome" name="name" id="name" value="{{ $supply->name }}" required />
        <x-input label="Unidade de Medida" name="unit_of_measure" id="unit_of_measure" value="{{ $supply->unit_of_measure }}" required />
        <x-select name="client_id" id="client_id" label="Cliente" class="min-w-[300px]" required>
                <option value="">Selecione um cliente</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" @selected(old('client_id', $supply->client_id) == $client->id)>{{ $client->name }}</option>
                @endforeach
        </x-select>

    </x-form>
@endsection
