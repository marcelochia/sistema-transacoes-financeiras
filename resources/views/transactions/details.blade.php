<x-layout>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2>Detalhes da transação</h2>
        </div>
        <div>
            <a href="{{route('transaction.index')}}" class="btn btn-sm btn-primary">Voltar</a>
        </div>
    </div>

    <div class="d-flex pt-3 my-3 bd-highlight border border-1">
        <div class="d-flex d-inline-flex">
            <table class="table table-bordered border-light">
                <tbody>
                    <tr>
                        <th scope="row">Data da transação:</th>
                        <td class="table-secondary">{{ $record->data_transacao->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Importado em:</th>
                        <td class="table-secondary">{{ $record->data_importacao->format('d/m/Y h:i:s') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Importado por:</th>
                        <td class="table-secondary">{{ $userName }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="text-center">Transações registradas</h2>
    
    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th colspan="3">ORIGEM</th>
                <th colspan="3">DESTINO</th>
                <th rowspan="2">HORA</th>
                <th rowspan="2">VALOR (R$)</th>
            </tr>
            <tr class="text-center">
                <th>BANCO</th>
                <th>AGÊNCIA</th>
                <th>CONTA</th>
                <th>BANCO</th>
                <th>AGÊNCIA</th>
                <th>CONTA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <td>{{$transaction->banco_origem}}</td>
                <td>{{$transaction->agencia_origem}}</td>
                <td>{{$transaction->conta_origem}}</td>
                <td>{{$transaction->banco_destino}}</td>
                <td>{{$transaction->agencia_destino}}</td>
                <td>{{$transaction->conta_destino}}</td>
                <td>{{$transaction->hora}}</td>
                <td class="text-end">{{number_format($transaction->valor, 2, ',', '.')}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>