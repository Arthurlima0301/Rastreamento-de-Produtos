@props([
    'title',
])

<flux:card {{ $attributes->class('w-full mb-3') }}>
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            
            <flux:button variant="ghost" class="p-0" onclick="window.history.back()">
                <flux:icon name="arrow-left" />
            </flux:button>

            <flux:heading size="lg">{{ $title }}</flux:heading>
        </div>

        <div>
            {{ $slot }}
        </div>
    </div>
</flux:card>
