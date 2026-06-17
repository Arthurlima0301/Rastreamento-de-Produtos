<div class="w-full space-y-4">
    <x-search-input />

    <x-table :paginate="$orders">
        <x-slot:header>
            <flux:table.column align="center">Código</flux:table.column>
            <flux:table.column align="center">Cliente</flux:table.column>
            <flux:table.column align="center">Status</flux:table.column>
            <flux:table.column align="center">Ações</flux:table.column>
        </x-slot:header>

        <x-slot:rows>
            @foreach ($orders as $order)
                <flux:table.row wire:key="order-{{ $order->id }}">
                    <flux:table.cell align="center">
                        <a href="{{ route('orders.show', $order->id) }}" class="hover:underline">
                            {{ $order->order_code }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell align="center">{{ $order->client->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $order->status }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <div class="flex justify-center gap-2">
                            <x-button href="{{ route('orders.edit', $order->id) }}" variant="ghost" icon="pencil" />
                            <x-button type="button" variant="primary" color="red" icon="trash" wire:click="destroy({{ $order->id }})" />
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:rows>
    </x-table>
</div>
