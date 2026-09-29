@props([
    'paginate' => null,
])

<flux:table :paginate="$paginate" container:class="w-full max-h-[75vh]">
    <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
        {{ $header }}
    </flux:table.columns>

    @if ($paginate !== null && $paginate->isEmpty())
        <flux:table.cell align="center" colspan="100%" class="py-4">
            <p class="text-sm text-gray-500">Nenhum resultado encontrado.</p>
        </flux:table.cell>
    @else
        <flux:table.rows>
            {{ $rows }}
        </flux:table.rows>
    @endif
</flux:table>
