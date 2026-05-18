<div class="w-full space-y-4">
    <x-search-input />

    <x-table>
        <x-slot name="header">
            <th class="p-2">Nome</th>
            <th class="p-2">Código</th>
            <th class="p-2">Unidade de Medida</th>
            <th class="p-2">Cliente</th>
            <th class="p-2">Ações</th>
        </x-slot>

        <x-slot name="rows">
            @foreach ($supplies as $supply)
                <tr class="hover:bg-hovered">
                    <td class="p-2">{{ $supply->name }}</td>
                    <td class="p-2">{{ $supply->supply_code }}</td>
                    <td class="p-2">{{ $supply->unit_of_measure }}</td>
                    <td class="p-2">{{ $supply->client->name }}</td>
                    <td class="p-2">
                        <a href="{{ route('supplies.show', $supply->id) }}">Ver</a>
                        <a href="{{ route('supplies.edit', $supply->id) }}">Editar</a>
                        <form action="{{ route('supplies.destroy', $supply->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>

    {{ $supplies->links(data: ['scrollTo' => false]) }}
</div>
