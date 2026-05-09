<div class="w-full space-y-4">
    <x-search-input />

    <x-table>
        <x-slot name="header">
            <th class="p-2">ID</th>
            <th class="p-2">
                Data:
                <select name="field" id="field" wire:model.live="parameter">
                    <option value="desc" class="text-mtext">Mais Recentes</option>
                    <option value="asc" class="text-mtext">Mais Antigas</option>
                </select>
            </th>
            <th class="p-2">Nota Fiscal</th>
            <th class="p-2">Ações</th>
        </x-slot>

        <x-slot name="rows">
            @foreach ($dispatches as $dispatch)
                <tr class="hover:bg-hovered">
                    <td class="p-2">{{ $dispatch->id }}</a></td>
                    <td class="p-2">{{ $dispatch->dispatched_at }}</td>
                    <td class="p-2">{{ $dispatch->invoice ?? 'N/A' }}</td>
                    <td><a href="{{ route('dispatches.show', $dispatch->id) }}">Ver</a></td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>

    {{ $dispatches->links(data: ['scrollTo' => false]) }}
</div>
