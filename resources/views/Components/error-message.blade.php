@php
    $errorMessage = session('error') ?? ($errors->any() ? $errors->first() : null);
@endphp

@if ($errorMessage)
    <x-alpine-assets />

    <div x-data class="flex justify-center items-center gap-3 w-full p-4 m-3 bg-danger rounded-md text-muted text-lg" @click.outside="$el.remove()">
        <img src="{{ asset('/img/icons/icon-error.svg') }}" alt="Error" class="h-10">
        <p>{{ $errorMessage }}</p>
    </div>
@endif
