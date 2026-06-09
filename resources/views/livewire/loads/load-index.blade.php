<div class="w-full">
    <x-card title="Cargas">
        <x-slot>
            <x-button href="{{ route('loads.create') }}" icon="plus" variant="primary">Nova Carga</x-button>
        </x-slot>
    </x-card>

    <x-success-message/>
    <x-error-message/>

    <livewire:loads.load-table />
</div>
