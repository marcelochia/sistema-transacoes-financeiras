<x-layout>

    <h2>{{ $title }}</h2>

    @isset($created)
        <div class="alert alert-success">
            {{ $created }}
        </div>
    @endisset

    @if (isset($user))
        <form action="{{ route('users.update', $user->id) }}" method="POST">
        @method('PUT')
    @else
        <form action="{{ route('users.store') }}" method="POST">
    @endif
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome completo</label>
            <input type="text" class="form-control" name="name" id="name" 
                value="@isset($user){{$user->name}}@endisset" 
                required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control @isset($error) is-invalid @endisset" name="email" id="email" 
                value="@isset($user){{$user->email}}@endisset"
                required>
            @isset($error)
                <div class="invalid-feedback">
                    {{ $error }}
                </div>
            @endisset   
        </div>
        <button type="submit" class="btn btn-primary">@if (isset($user))
            Editar
        @else
            Cadastrar
        @endif</button>
        @isset($user)            
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Voltar</a>
        @endisset
    </form>

</x-layout>