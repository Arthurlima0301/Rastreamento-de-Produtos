@props([
    'columnTitle' => null,
    'model' => null,

])

<flux:dropdown>
    <flux:button icon:trailing="chevron-down">{{ $columnTitle }}</flux:button>

    <flux:menu>
        <flux:menu.radio.group wire:model.live="{{ $model }}">
             {{ $slot }}
        </flux:menu.radio.group>
    </flux:menu>
</flux:dropdown>
