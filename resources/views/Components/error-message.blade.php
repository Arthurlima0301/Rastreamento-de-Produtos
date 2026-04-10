@php
    $errorMessage = session('error') ?? ($errors->any() ? $errors->first() : null);
@endphp

@if ($errorMessage)
    <div class="flex justify-center items-center gap-3 p-4 bg-danger rounded-md text-muted text-lg">
        <img src="{{ asset('/img/icons/icon-error.svg') }}" alt="Error" class="h-10">
        <p>{{ $errorMessage }}</p>
    </div>
@endif
