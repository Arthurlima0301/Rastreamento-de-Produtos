<div class="flex items-center gap-2 w-full">
    @if (! $isEditing)
        <p><strong>Código: </strong>{{ $load->machine->abbreviation }}-{{ $load->id }}</p>
        <p><strong>Data de Corte: </strong> {{ $load->formatted_cutted_at }}</p>
        <p><strong>Turno: </strong> {{ $load->turn }}</p>
        <p><strong>Máquina: </strong> {{ $load->machine->name }}</p>
        <p><strong>Peso Total: </strong> {{ number_format($load->rolls->sum('weight'), 2, ',', '.') }}</p>

        <x-button icon="pencil" variant="ghost" wire:click="edit" />
    @else
        <strong>Código: </strong><x-input value="{{ $load->machine->abbreviation }}-{{ $load->id }}" readonly />
        <strong>Data: </strong><x-input type="date" wire:model="form.cutted_at" />

        <strong>Turno: </strong>
        <x-select wire:model="form.turn">
            <option value="DIURNO">Diurno</option>
            <option value="VESPERTINO">Vespertino</option>
            <option value="NOTURNO">Noturno</option>
        </x-select>

        <strong>Máquina: </strong>
        <x-select wire:model="form.machine_id">
            @foreach ($machines as $machine)
                <option value="{{ $machine->id }}">{{ $machine->name }}</option>
            @endforeach
        </x-select>

        <x-button variant="primary" wire:click="save">Salvar</x-button>
        <x-button variant="primary" color="red" wire:click="cancelEdit">Cancelar</x-button>
    @endif

    @error('form.*')
        <p>{{ $message }}</p>
    @enderror
</div>
