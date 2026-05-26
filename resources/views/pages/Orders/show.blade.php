@extends('Layout.layout')

@section('title', 'Pedido - Detalhes')

@section('content')
    <x-card title="Detalhes do Pedido">
        <x-slot name="slot">
            <p><strong>Codigo:</strong> {{ $order->code }}</p>
            <p><strong>Cliente:</strong> {{ $order->client->name }}</p>
            <p><strong>Quantidade de Materiais:</strong> {{ $order->materials_count }}</p>
        </x-slot>
    </x-card>

    <x-table :paginate="null">
        <x-slot:header>
            <flux:table.column align="center">Item</flux:table.column>
            <flux:table.column align="center">Papel</flux:table.column>
            <flux:table.column align="center">Codigo de Envio</flux:table.column>
            <flux:table.column align="center">Codigo de Expedicao</flux:table.column>
            <flux:table.column align="center">Gramatura</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($order->materials as $material)
                <flux:table.row>
                    <flux:table.cell align="center">{{ $material->item_number }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->paper }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->shipping_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->expedition_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $material->formatted_grammage }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
@endsection
