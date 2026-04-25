@extends('Layout.layout')

@section('title', 'Notas Fiscais')

@section('content')
    <x-card title="Notas Fiscais">
        <x-slot name="slot">
            <form action="{{ route('invoices.import') }}" method="POST" enctype="multipart/form-data" x-ref="form">
                @csrf
                <label for="xml_file">Arquivo XML</label>
                <input type="file" class="hidden" name="xml_file" id="xml_file" accept=".xml" required
                    @change = "$refs.form.submit()">
            </form>
        </x-slot>
    </x-card>

    <x-sucess-message></x-sucess-message>
    <x-error-message></x-error-message>

    <x-table>
        <x-slot name="header">
            <th class="p-2">ID</th>
            <th class="p-2">Código NF</th>
            <th class="p-2">Data de Emissão</th>
        </x-slot>

        <x-slot name="rows">
            @foreach ($invoices as $invoice)
                <tr>
                    <td class="p-2">{{ $invoice->id }}</td>
                    <td class="p-2">{{ $invoice->invoice_code }}</td>
                    <td class="p-2">{{ $invoice->issued_at }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
@endsection
