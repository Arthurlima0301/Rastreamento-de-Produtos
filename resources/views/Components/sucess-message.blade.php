@if (session()->has('success'))
    <div class="flex justify-center items-center gap-3 w-full p-4 m-3 bg-success rounded-md text-muted text-lg" @click.outside="$el.remove()">
        <img src="{{ asset('/img/icons/icon-success.svg') }}" alt="Success" class="h-10">
        <p>{{ session('success') }}</p>
    </div>
@endif
