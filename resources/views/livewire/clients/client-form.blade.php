<form wire:submit="save" class="flex justify-center w-full">
    <flux:card class="space-y-6">
        <flux:heading size="xl">{{ $clientId ? 'Editar' : 'Criar Cliente' }}</flux:heading>

        <div class="flex flex-col gap-4">
            <flux:input label="Nome" wire:model="name" required />
            @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <x-button type="submit" variant="primary" class="min-w-[300px]">
            {{ $clientId ? 'Salvar' : 'Criar Cliente' }}
        </x-button>
    </flux:card>
</form>
