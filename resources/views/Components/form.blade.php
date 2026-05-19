@props([
    'action',
    'method' => 'POST',
    'title' => 'Formulario',
    'buttonText' => 'Enviar',
])

<form action="{{ $action }}" method="{{ $method }}" {{ $attributes->class('flex justify-center w-full') }}>
    @csrf

    <flux:card class="space-y-6">
        <flux:heading size="xl">{{ $title }}</flux:heading>

        <div class="flex flex-col gap-4">
            {{ $slot }}
        </div>

        <x-button type="submit" variant="primary" class="min-w-[300px]">
            {{ $buttonText }}
        </x-button>
    </flux:card>
</form>
