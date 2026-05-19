@props([
    'paginate' => null,
])

<flux:table :paginate="$paginate" container:class="w-full max-h-[75vh]">
    <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
        {{ $header }}
    </flux:table.columns>

    <flux:table.rows>
        {{ $rows }}
    </flux:table.rows>
</flux:table>
