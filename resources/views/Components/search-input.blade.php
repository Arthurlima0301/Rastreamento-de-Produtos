<flux:input
    type="text"
    icon="magnifying-glass"
    {{ $attributes->merge([
        'placeholder' => 'Pesquisar...',
        'wire:model.live.debounce.300ms' => 'search',
    ])->class('w-full') }}
/>
