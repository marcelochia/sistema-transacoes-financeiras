<x-layout>
    <h2>Transações</h2>

    @isset($success)
        <div class="alert alert-success">
            {{ $success }}
        </div>
    @endisset    
    <form action="{{ route('transaction.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-2">
            <label for="csvfile" class="form-label">Selecione o arquivo CSV para realizar a importação:</label>
        </div>
        <div class="mb-2">
            <input type="file" name="csvfile" id="csvfile" class="form-control" autofocus>
        </div>
        <div class="mb-2 row">
            <div class="col-2">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
            <div class="col-10">
                @if ($errors->any())
                    <ul class="list-group list-group-flush">
                        @foreach ($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
          <tr>
            <th scope="col">Transação do dia:</th>
            <th scope="col">Importado em:</th>
            <th scope="col">Ações:</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($records as $record)
            <tr>
                <td>{{ $record->data_transacao->format('d/m/Y') }}</td>
                <td>{{ $record->data_importacao->format('d/m/Y h:i:s') }}</td>
                <td>
                    <a href="{{route('transaction.details', $record->id)}}" class="btn btn-sm btn-primary">Detalhar</a>
                </td>
            </tr>    
          @endforeach
        </tbody>
      </table>
</x-layout>