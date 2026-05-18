<div class="w-full space-y-4">
    <x-search-input />

    <x-table>
        <x-slot name="header">
            <th class="p-2">Nome</th>
            <th class="p-2">Ações</th>
        </x-slot>

        <x-slot name="rows">
            @foreach ($clients as $client)
                <tr class="hover:bg-hovered">
                    <td class="p-2">{{ $client->name }}</td>
                    <td class="p-2">
                        <a href="{{ route('clients.edit', $client->id) }}">Editar</a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>

    {{ $clients->links(data: ['scrollTo' => false]) }}
</div>
