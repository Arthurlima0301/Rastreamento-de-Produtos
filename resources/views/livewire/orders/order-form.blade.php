<form wire:submit="save" class="flex justify-center w-full">
    <flux:card class="space-y-6">
        <flux:heading size="xl">{{ $orderId ? 'Editar' : 'Criar Ordem de Corte' }}</flux:heading>

        <div class="flex flex-col gap-4">
            <flux:input label="Codigo" wire:model="order_code" required />

            <flux:select label="Cliente" wire:model="client_id" class="min-w-[300px]" required>
                <option value="">Selecione um cliente</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </flux:select>
        </div>

        <x-button type="submit" variant="primary" class="min-w-[300px]">
            {{ $orderId ? 'Salvar' : 'Criar Ordem de Corte' }}
        </x-button>
    </flux:card>
</form>
