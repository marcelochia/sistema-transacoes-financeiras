<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Análise de Transações Financeiras</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <header class="p-3 bg-dark text-white">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
    
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="{{ route('transaction.index') }}" class="nav-link px-2 text-white">Transações</a></li>
                <li><a href="{{ route('users.index') }}" class="nav-link px-2 text-white">Usuários</a></li>
            </ul>

            <div class="text-end">
                <form action="{{ route('login.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light me-2">Sair</button>
                </form>
            </div>
          </div>
        </div>
    </header>
    
    <div class="container">
        <div class="p-4 bg-dark text-white rounded-bottom">
            <h1>{{env('APP_NAME')}}</h1>
        </div>
        <div class="p-2">
            {{ $slot }}
        </div>
    </div>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>