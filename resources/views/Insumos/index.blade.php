<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Lista de Insumos</h1>
    <a href="{{ route('insumos.create') }}">Criar Novo Insumo</a>
    <table style="text-align: center;">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Código</th>
                <th>Unidade de Medida</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($insumos as $insumo)
                <tr>
                    <td>{{ $insumo->nome }}</td>
                    <td>{{ $insumo->codigo_insumo }}</td>
                    <td>{{ $insumo->unidade_medida }}</td>
                    <td>
                        <a href="{{ route('insumos.show', $insumo->id) }}">Ver</a>
                        <a href="{{ route('insumos.edit', $insumo->id) }}">Editar</a>
                        <form action="{{ route('insumos.destroy', $insumo->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>