@extends('Layout.layout')

@section('title', 'Notas Fiscais')

@section('content')
    <h1>Notas Fiscais</h1>

    <form action="{{ route('notas.import') }}" method="POST" enctype="multipart/form-data" x-ref="form">
        @csrf
        <label for="xml_file">Arquivo XML</label>
        <input type="file" class="hidden" name="xml_file" id="xml_file" accept=".xml" required
            @change = "$refs.form.submit()">
    </form>

    <x-sucess-message></x-sucess-message>
    <x-error-message></x-error-message>

    <x-table>
        <x-slot name="header">
            <th class="p-2">ID</th>
            <th class="p-2">Código NF</th>
            <th class="p-2">Data de Emissão</th>
            <th class="p-2">Criado em</th>
        </x-slot>

        <x-slot name="rows">
            @foreach ($notas as $nota)
                <tr>
                    <td class="p-2">{{ $nota->id }}</td>
                    <td class="p-2">{{ $nota->codigo_nf }}</td>
                    <td class="p-2">{{ $nota->data_emissao }}</td>
                    <td class="p-2">{{ $nota->created_at }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
@endsection
