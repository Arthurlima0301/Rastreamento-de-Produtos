@extends('Layout.layout')

@section('title', 'Nota Fiscal de Material - Detalhes')

@section('content')
    <x-card title="Detalhes da Nota Fiscal de Material">
        <x-slot name="slot">
            <p><strong>Codigo:</strong> {{ $materialInvoice->formatted_material_invoice_code }}</p>
            <p><strong>Data de Cadastro:</strong> {{ $materialInvoice->formatted_created_at }}</p>
            <p><strong>Quantidade de Itens:</strong> {{ $materialInvoice->material_items_count }}</p>
        </x-slot>
    </x-card>

    <x-table :paginate="null">
        <x-slot:header>
            <flux:table.column align="center">Material</flux:table.column>
            <flux:table.column align="center">Pedido</flux:table.column>
            <flux:table.column align="center">Quantidade de Bobinas</flux:table.column>
            <flux:table.column align="center">Peso</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($materialInvoice->materialItems as $materialItem)
                <flux:table.row>
                    <flux:table.cell align="center">{{ $materialItem->material->paper }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialItem->material->order->code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialItem->formatted_roll_quantity }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $materialItem->formatted_weight }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
@endsection
