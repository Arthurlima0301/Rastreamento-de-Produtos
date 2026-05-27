<div class="w-full">
    <x-card title="Saídas">
        <x-slot name="slot">
            <x-button href="{{ route('dispatches.create') }}" variant="primary" icon="plus">
                Criar Nova Saída
            </x-button>
        </x-slot>
    </x-card>

    <x-success-message />

    <livewire:dispatches.dispatch-table />
</div>
