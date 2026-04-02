<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Criar Insumo</h1>
    @if ($errors->any())
        <p>{{ $errors->first() }}</p>
    @endif
    <form action="{{ route('insumos.store') }}" method="POST">
        @csrf
        <div>
            <label for="codigo_insumo">Código:</label>
            <input type="text" name="codigo_insumo" id="codigo_insumo" required>
        </div>
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>
        </div>
        <div>
            <label for="unidade_medida">Unidade de Medida:</label>
            <input type="text" name="unidade_medida" id="unidade_medida" required>
        </div>
        <button type="submit">Criar Insumo</button>
    </form>

</body>

</html>
