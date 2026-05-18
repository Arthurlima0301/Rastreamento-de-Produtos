@extends('Layout.layout')

@section('title', 'Criar Cliente')

@section('content')
<x-card title="Criar Cliente"></x-card>

<x-error-message></x-error-message>

<x-form action="{{ route('clients.store') }}" method="POST" title="Criar Cliente" buttonText="Criar Cliente">
    <x-input name="name" label="Nome" type="text" value="" required></x-input>
</x-form>

@endsection
