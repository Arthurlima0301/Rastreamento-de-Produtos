<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
    <table class="text-center">
        <thead>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Item</th>
                <th>Unidade de Medida</th>
                <th>Quantidade</th>
                <th>Nota Fiscal</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->insumo->codigo_insumo }}</td>
                    <td>{{ $item->insumo->nome}}</td>
                    <td>{{ $item->numero }}</td>
                    <td>{{ $item->insumo->unidade_medida }}</td>
                    <td>{{ $item->quantidade }}</td>
                    <td>{{ $item->notaFiscal->codigo_nf }}</td>
                    <td>{{ $item->notaFiscal->data_emissao}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>