<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$orders">
        <x-slot:header>
            <flux:table.column align="center">Codigo</flux:table.column>
            <flux:table.column align="center">Cliente</flux:table.column>
            <flux:table.column align="center">Quantidade de Materiais</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($orders as $order)
                <flux:table.row wire:key="order-{{ $order->id }}">
                    <flux:table.cell align="center">{{ $order->code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $order->client->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $order->materials_count }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <x-button href="{{ route('orders.show', $order->id) }}" variant="ghost" icon="eye" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
