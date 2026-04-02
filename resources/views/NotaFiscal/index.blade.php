<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas Fiscais</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body x-data="{}">
    <h1>Notas Fiscais</h1>

    @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('notas.import') }}" method="POST" enctype="multipart/form-data" x-ref="form">
        @csrf
        <label for="xml_file">Arquivo XML</label>
        <input type="file" class="hidden" name="xml_file" id="xml_file" accept=".xml" required
        
        @change = "$refs.form.submit()">

        @if($errors->isNotEmpty())
        <p style="color:red;">{{ $errors->first() }}</p>
        @enderror
    </form>

    <h2>Lista de notas fiscais</h2>

    @if ($notas->isEmpty())
    <p>Nenhuma nota fiscal registrada.</p>
    @else
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Código NF</th>
                <th>Data de Emissão</th>
                <th>Criado em</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notas as $nota)
            <tr>
                <td>{{ $nota->id }}</td>
                <td>{{ $nota->codigo_nf }}</td>
                <td>{{ $nota->data_emissao }}</td>
                <td>{{ $nota->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</body>

</html>