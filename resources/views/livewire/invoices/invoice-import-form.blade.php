<div class="flex flex-col items-end gap-2 w-full">
    <x-button
        variant="primary"
        icon="arrow-up-tray"
        class="max-w-[200px]"
    >
        <label for="xml_file" class="cursor-pointer" wire:loading.remove wire:target="import">
            Importar XML
        </label>


        <span wire:loading wire:target="import">Importando...</span>

        <input
            type="file"
            class="hidden"
            wire:model="xml_file"
            id="xml_file"
            accept=".xml"
            required

            x-on:livewire-upload-finish="$wire.import()"
        >
    </x-button>

    @error('xml_file')
        <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror
</div>
