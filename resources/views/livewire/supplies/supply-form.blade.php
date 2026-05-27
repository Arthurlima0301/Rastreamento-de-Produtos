<form wire:submit="save" class="flex justify-center w-full">
    <flux:card class="space-y-6">
        <flux:heading size="xl">{{ $supplyId ? 'Editar' : 'Criar Insumo' }}</flux:heading>

        <div class="flex flex-col gap-4">
            <flux:input label="Código" wire:model="supply_code" required />
            @error('supply_code')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <flux:input label="Nome" wire:model="name" required />
            @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <flux:input label="Unidade de Medida" wire:model="unit_of_measure" required />
            @error('unit_of_measure')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <flux:select label="Cliente" wire:model="client_id" class="min-w-[300px]" required>
                <option value="">Selecione um cliente</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </flux:select>
            @error('client_id')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <x-button type="submit" variant="primary" class="min-w-[300px]">
            {{ $supplyId ? 'Salvar' : 'Criar Insumo' }}
        </x-button>
    </flux:card>
</form>
