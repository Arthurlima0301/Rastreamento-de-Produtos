@php
    $errorMessage = session('error') ?? ($errors->any() ? $errors->first() : null);
@endphp

@if ($errorMessage)
    <flux:callout
        x-data
        variant="danger"
        icon="x-circle"
        class="w-full my-3"
        @click.outside="$el.remove()"
    >
        <flux:callout.text>{{ $errorMessage }}</flux:callout.text>
    </flux:callout>
@endif
