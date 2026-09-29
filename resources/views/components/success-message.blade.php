@if (session()->has('success'))
    <flux:callout
        x-data
        variant="success"
        icon="check-circle"
        class="w-full my-3"
        @click.outside="$el.remove()"
    >
        <flux:callout.text>{{ session('success') }}</flux:callout.text>
    </flux:callout>
@endif
