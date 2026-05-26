@extends('Layout.layout')

@section('title', 'Notas Fiscais de Material')

@section('content')
    <x-card title="Notas Fiscais de Material">
        <x-button variant="primary" icon="arrow-up-tray">
            <form action="{{ route('material-invoices.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="xml_file">Importar XML</label>

                <input type="file" class="hidden" name="xml_file" id="xml_file" accept=".xml" required
                    onchange="this.form.submit()">
            </form>
        </x-button>
    </x-card>

    <x-success-message></x-success-message>
    <x-error-message></x-error-message>

    <livewire:material-invoices.material-invoice-table />
@endsection
