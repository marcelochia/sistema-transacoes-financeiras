<x-layout>
    <div>
        <h2>Análise de transações suspeitas</h2>

        <form action="" method="GET">
            <label class="form-label" for="competence">Selecione o mês:</label>
            <select class="form-select" name="competence" id="competence">
                @foreach ($dates as $date)
                <option value="{{$date->date}}">{{$date->date}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Analisar</button>
        </form>
    </div>

    @if($suspectTransactions)
        <h3 class="text-center mt-4">Transações suspeitas</h3>

        <table class="table table-bordered mb-5">
            <thead>
                <tr class="text-center">
                    <th colspan="3">ORIGEM</th>
                    <th colspan="3">DESTINO</th>
                    <th rowspan="2">DATA</th>
                    <th rowspan="2">HORA</th>
                    <th rowspan="2">VALOR</th>
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
            <tbody id="transactionsList">
                @foreach ($transactions as $transaction)
                <tr>
                    <td>{{$transaction->banco_origem}}</td>
                    <td>{{$transaction->agencia_origem}}</td>
                    <td>{{$transaction->conta_origem}}</td>
                    <td>{{$transaction->banco_destino}}</td>
                    <td>{{$transaction->agencia_destino}}</td>
                    <td>{{$transaction->conta_destino}}</td>
                    <td>{{$transaction->data}}</td>
                    <td>{{$transaction->hora}}</td>
                    <td>R$ {{number_format($transaction->valor, 2, ',', '.')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="text-center mt-4">Contas suspeitas</h3>
    
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="text-center">
                    <th>BANCO</th>
                    <th>AGÊNCIA</th>
                    <th>CONTA</th>
                    <th>VALOR MOVIMENTADO</th>
                    <th>TIPO DE MOVIMENTAÇÃO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                <tr>
                    <td>{{$account->bank}}</td>
                    <td>{{$account->agency}}</td>
                    <td>{{$account->account}}</td>
                    <td>R$ {{number_format($account->value, 2, ',', '.')}}</td>
                    <td>@if ($account->type === 'saida') Saída @else Entrada @endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="text-center mt-4">Agências suspeitas</h3>
    
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="text-center">
                    <th>BANCO</th>
                    <th>AGÊNCIA</th>
                    <th>VALOR MOVIMENTADO</th>
                    <th>TIPO DE MOVIMENTAÇÃO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agencies as $agency)
                <tr>
                    <td>{{$agency->bank}}</td>
                    <td>{{$agency->agency}}</td>
                    <td>R$ {{number_format($agency->value, 2, ',', '.')}}</td>
                    <td>@if ($agency->type === 'saida') Saída @else Entrada @endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</x-layout>