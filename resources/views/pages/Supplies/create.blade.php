@extends('Layout.layout')

@section('title', 'Criar Insumo')

@section('content')
    <x-card title="Criar Insumo"></x-card>

    <x-error-message></x-error-message>

    <x-form action="{{ route('supplies.store') }}" method="POST" title="Criar Insumo" buttonText="Criar Insumo">

        <x-input name="supply_code" label="Código" type="text" value="" required></x-input>

        <x-input name="name" label="Nome" type="text" value="" required></x-input>

        <x-input name="unit_of_measure" label="Unidade de Medida" type="text" value="" required></x-input>

        <div class="flex flex-col gap-2">

            <label for="client_id">Cliente</label>

            <select name="client_id" id="client_id" class="min-w-[300px] border border-stroke rounded-md p-2" required>

                <option value="">Selecione um cliente</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>{{ $client->name }}</option>
                @endforeach
                
            </select>
        </div>
    </x-form>

@endsection
