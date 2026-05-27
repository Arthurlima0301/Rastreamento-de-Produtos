<div class="w-full">
    <x-card title="Editar Insumo">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <livewire:supplies.supply-form :supply-id="$supplyId" />
</div>
