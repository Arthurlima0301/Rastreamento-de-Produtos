<div class="w-full">
    <x-card title="Cargas">
        <x-slot>
            <x-button href="{{ route('loads.create') }}" icon="plus" variant="primary">Nova Carga</x-button>
        </x-slot>
    </x-card>

    <livewire:loads.load-table />
</div>
