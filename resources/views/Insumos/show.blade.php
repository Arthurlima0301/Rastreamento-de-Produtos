<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Detalhes do Insumo</h1>
    <p><strong>Código:</strong> {{ $insumo->codigo_insumo }}</p>
    <p><strong>Nome:</strong> {{ $insumo->nome }}</p>
    <p><strong>Unidade de Medida:</strong> {{ $insumo->unidade_medida }}</p>
</body>
</html>