<x-layout>
    <h2>Usuários</h2>

    @isset($userRemoved)
        <div class="alert alert-success">
            {{ $userRemoved }}
        </div>
    @endisset

    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">Cadastrar usuário</a>

    <table class="table align-middle">
        <thead>
            <tr>
                <th scope="col" style="width: 10%">ID</th>
                <th scope="col" style="width: 40%">Nome</th>
                <th scope="col" style="width: 30%">E-mail</th>
                <th scope="col" style="width: 20%">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pen"></i> Editar
                    </a>
                    @if ($authUserId !== $user->id)
                        <button name="delete" onclick="deleteUser({{ $user->id }})" class="btn btn-sm btn-danger">
                            <i class="bi bi-pen"></i> Excluir
                        </button>
                    @endif
                </td>
            </tr>
            @endforeach

            @if (count($users) == 0)
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            @endif
        </tbody>
    </table>

    <script>
        function deleteUser(id) {
            let ok = confirm("Deseja excluir esse usuário?");
            let url = '/usuarios/remover';

            if (ok) {
                fetch(url, {
                    method: "DELETE",
                    headers: {
                        'X-ID': id,
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url
                    }
                });
            }
        }
    </script>
    
</x-layout>