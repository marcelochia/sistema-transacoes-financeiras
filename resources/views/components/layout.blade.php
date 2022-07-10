<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Análise de Transações Financeiras</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-light">

    <div class="container">
        <div class="p-5 bg-dark text-white rounded">
            <h2>{{ $subtitle }}</h2>
        </div>
        <div class="p-2">
            {{ $slot }}
        </div>
    </div>

</body>
</html>