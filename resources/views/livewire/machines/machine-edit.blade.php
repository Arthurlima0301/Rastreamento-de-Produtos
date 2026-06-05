<div class="w-full">
    <x-card title="Editar Máquina">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <livewire:machines.machine-form :machine-id="$machineId" />
</div>
