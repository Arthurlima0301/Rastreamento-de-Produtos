@extends('Layout.layout')

@section('title', 'Notas Fiscais')

@section('content')
    <x-card title="Notas Fiscais">
        <x-button variant="primary" icon="arrow-up-tray" >

            <form action="{{ route('invoices.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="xml_file">Importar XML</label>

                <input type="file" class="hidden" name="xml_file" id="xml_file" accept=".xml" required
                    onchange="this.form.submit()">
            </form>
        </x-button>
    </x-card>

    <x-success-message></x-success-message>
    <x-error-message></x-error-message>

    <livewire:invoices.invoice-table />
@endsection
