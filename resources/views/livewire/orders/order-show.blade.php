<div class="w-full">
    <x-error-message />

    <x-card title="Detalhes da Ordem de Corte">
        <x-slot name="slot">
            <div class="flex items-center gap-4">
                <p><strong>Codigo:</strong> {{ $order->order_code }}</p>
                <p><strong>Cliente:</strong> {{ $order->client->name }}</p>
            </div>
        </x-slot>
    </x-card>
</div>
