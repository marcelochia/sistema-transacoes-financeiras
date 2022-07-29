<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransationsFormRequest;
use App\Models\Record;
use App\Models\Transaction;
use App\Models\User;
use App\Services\ReadFile;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    public function __construct(private ReadFile $readFile) {}

    public function index()
    {
        $records = Record::orderByDesc('data_transacao')->get();

        $successMessage = session('success.message');

        return view('transactions.index')
            ->with('records', $records)
            ->with('success', $successMessage);
    }

    public function store(TransationsFormRequest $request)
    {
        $file = $request->file('transactionfile');

        $transactions = $this->readFile->process($file);

        $dateTransaction = $transactions['dateTransaction'];

        $result = DB::table('transacoes')->where('data', $transactions['dateTransaction'])->first('data');
        
        if (!is_null($result)) {
            return to_route('transaction.index')
                ->with('success.message', 'Transações financeiras do dia ' . 
                                            date('d/m/Y', strtotime($dateTransaction)) . 
                                            ' já foram importadas anteriormente!');
        }

        $record = new Record();
        $record->data_transacao = $dateTransaction;
        $record->user_id = Auth::id();
        $record->save();

        foreach ($transactions as $transactions) {    
            if (substr($transactions[7], 0, 10) === $dateTransaction) {
                $transaction = new Transaction();
                $transaction->banco_origem      = $transactions[0];
                $transaction->agencia_origem    = $transactions[1];
                $transaction->conta_origem      = $transactions[2];
                $transaction->banco_destino     = $transactions[3];
                $transaction->agencia_destino   = $transactions[4];
                $transaction->conta_destino     = $transactions[5];
                $transaction->valor             = $transactions[6];
                $transaction->data              = $dateTransaction;
                $transaction->hora              = substr($transactions[7], 11, 19);
                $transaction->registro_id       = $record->id;
                $transaction->save();
            }
        }

        return to_route('transaction.index')
            ->with('success.message', 'Transações financeiras do dia ' . 
                                        date('d/m/Y', strtotime($dateTransaction)) . 
                                        ' importadas com sucesso!');
    }

    public function details(Record $record)
    {
        $transactions = Transaction::where('registro_id', $record->id)->get();
        $user = User::withTrashed()->where('id', $record->user_id)->first();

        return view('transactions.details', [
            'record' => $record,
            'transactions' => $transactions,
            'userName' => $user->name
        ]);
    }
}
