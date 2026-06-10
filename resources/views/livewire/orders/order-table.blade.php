<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$orders">
        <x-slot:header>
            <flux:table.column align="center">Codigo</flux:table.column>
            <flux:table.column align="center">Cliente</flux:table.column>
            <flux:table.column align="center">Status</flux:table.column>
            <flux:table.column align="center">Acoes</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($orders as $order)
                <flux:table.row wire:key="order-{{ $order->id }}">
                    <flux:table.cell align="center">{{ $order->order_code }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $order->client->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $order->status }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <div class="flex justify-center gap-2">
                            <x-button href="{{ route('orders.show', $order->id) }}" variant="ghost" icon="eye" />
                            <x-button href="{{ route('orders.edit', $order->id) }}" variant="ghost" icon="pencil" />
                            <x-button type="button" variant="danger" icon="trash" wire:click="destroy({{ $order->id }})" />
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
