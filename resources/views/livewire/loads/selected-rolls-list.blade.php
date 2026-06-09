<div class="w-full">
    <flux:card class="space-y-2">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Detalhe da Carga</flux:heading>

            <x-button variant="ghost" wire:click="clearSelection">
                Limpar Bobinas
            </x-button>
        </div>

        <div class="flex gap-2">
            <x-select class="mb-2" wire:model="selectedMachineId">
                <flux:select.option value="">Máquina</flux:select.option>
                @foreach ($machines as $machine)
                    <flux:select.option value="{{ $machine->id }}">{{ $machine->name }}</flux:select.option>
                @endforeach
            </x-select>

            <x-select class="w-[100px]" wire:model="selectedTurn">
                <flux:select.option value="">Turno</flux:select.option>
                <flux:select.option value="DIURNO">Diurno</flux:select.option>
                <flux:select.option value="VESPERTINO">Vespertino</flux:select.option>
                <flux:select.option value="NOTURNO">Noturno</flux:select.option>
            </x-select>

            <x-input class="w-[150px]" type="date" wire:model="selectedCuttedAt"    />
        </div>

        @if ($errors->any())
            <p class="text-center text-red-500">{{ $errors->first() }}</p>
        @endif

        <div class="space-y-2">
            @if (empty($selectedRolls))
                <p class="text-center text-gray-500">Nenhuma bobina selecionada.</p>
            @else
                @foreach ($selectedRolls as $roll)
                    <div class="flex items-center space-x-4 w-full" wire:key="selected-roll-{{ $roll['id'] }}">
                        <p class="text-lg">{{ $roll['label'] }}</p>
                        <p class="text-lg">{{ $roll['weight'] }}</p>

                        <x-input class="!w-1/3" placeholder="Defeito" wire:model="selectedRolls.{{ $roll['id'] }}.{{'defect'}}" />
                        <x-input class="!w-[120px]" placeholder="Peso" wire:model="selectedRolls.{{ $roll['id'] }}.{{'defect_weight'}}" />

                        <x-button variant="ghost" icon="x-mark" wire:click="removeRoll({{ $roll['id'] }})" />
                    </div>
                @endforeach
        </div>

        <x-button variant="primary" class="w-full mt-2" wire:click="save">
            Criar Carga
        </x-button>
        @endif

    </flux:card>
</div>
