@props([
    'collumnTitle' => null,
    'model' => null,

])

<flux:dropdown>
    <flux:button icon:trailing="chevron-down">{{ $collumnTitle }}</flux:button>

    <flux:menu>
        <flux:menu.radio.group wire:model.live="{{ $model }}">
             {{ $slot }}
        </flux:menu.radio.group>
    </flux:menu>
</flux:dropdown>
