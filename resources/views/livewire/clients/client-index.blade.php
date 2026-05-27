<div class="w-full">
    <x-card title="Lista de Clientes">
        <x-slot name="slot">
            <x-button href="{{ route('clients.create') }}" variant="primary" icon="plus">
                Criar Novo Cliente
            </x-button>
        </x-slot>
    </x-card>

    <x-success-message />
    <x-error-message />

    <livewire:clients.client-table />
</div>
