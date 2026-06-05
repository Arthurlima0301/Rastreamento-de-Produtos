<div class="w-full">
    <x-card title="Máquinas">
        <x-button href="{{ route('machines.create') }}" variant="primary" icon="plus">
            Criar Nova Máquina
        </x-button>
    </x-card>

    <x-success-message />
    <x-error-message />

    <livewire:machines.machine-table />
</div>
