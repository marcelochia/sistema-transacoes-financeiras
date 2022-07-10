<x-layout subtitle="IMPORTAR TRANSAÇÕES FINANCEIRAS">
    <form action="{{ route('transaction.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-2">
            <label for="csvfile" class="form-label">Selecione o arquivo CSV</label>
        </div>
        <div class="mb-2">
            <input type="file" name="csvfile" id="csvfile" class="form-control" autofocus>
        </div>
        <div class="mb-2">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>
</x-layout>