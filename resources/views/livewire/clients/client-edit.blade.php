<div class="w-full">
    <x-card title="Editar Cliente">
        <x-slot name="slot">
            <!-- action slot left intentionally empty -->
        </x-slot>
    </x-card>

    <livewire:clients.client-form :client-id="$clientId" />
</div>
