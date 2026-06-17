<div class="w-full">
    <x-card title="Ordens de Corte">
        <x-button href="{{ route('orders.create') }}" variant="primary" icon="plus">
            Criar Nova Ordem de Corte
        </x-button>
    </x-card>

    <x-success-message />
    <x-error-message />

    <livewire:orders.order-table />
</div>
