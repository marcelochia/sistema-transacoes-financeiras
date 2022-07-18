<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Análise de Transações Financeiras</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.2/examples/sign-in/signin.css">
</head>
<body class="container d-flex justify-content-center text-center">

    <div>
        <h4 class="mt-1 pb-1">Login</h4>
        @if ($errors->any())
            <ul class="list-group list-group-flush">
                @foreach ($errors->all() as $error)
                    <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form action="{{ route('login.action') }}" method="POST">
            @csrf
            <div class="form-floating mb-4">
                <input type="email" name="email" id="email" class="form-control" />
                <label class="form-label" for="email">E-mail</label>
            </div>
          
            <div class="form-floating mb-4">
                <input type="password" name="password" id="password" class="form-control" />
                <label class="form-label" for="password">Senha</label>
            </div>
          
            <div class="row mb-4">
                <button type="submit" class="btn btn-primary btn-block mb-4">Entrar</button>
            </div>
          </form>
    </div>

</body>
</html>