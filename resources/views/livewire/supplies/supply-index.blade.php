<div class="w-full">
    <x-card title="Insumos">
        <x-button href="{{ route('supplies.create') }}" variant="primary" icon="plus">
            Criar Novo Insumo
        </x-button>
    </x-card>

    <x-success-message />
    <x-error-message />

    <livewire:supplies.supply-table />
</div>
