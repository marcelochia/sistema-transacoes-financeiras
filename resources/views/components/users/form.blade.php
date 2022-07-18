    <form action="{{ $action }}" method="POST">
        @if ($update)
            @method('PUT')
        @endif
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome completo</label>
            <input type="text" class="form-control" name="name" id="name" 
                value="@isset($name){{$name}}@endisset" 
                required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control @isset($invalidEmail) is-invalid @endisset" name="email" id="email" 
                value="@isset($email){{$email}}@endisset"
                required>
            @isset($invalidEmail)
                <div class="invalid-feedback">
                    {{ $invalidEmail }}
                </div>
            @endisset   
        </div>
        <button type="submit" class="btn btn-primary">
            @if ($update)
                Editar
            @else
                Cadastrar
            @endif
        </button>
    </form>