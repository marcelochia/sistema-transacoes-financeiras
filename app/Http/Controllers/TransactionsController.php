<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransationsFormRequest;
use App\Models\Record;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
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
        $file = fopen($request->file('csvfile'), "r");

        $lines = [];
        $dateTransaction = null;
        
        while (($data = fgetcsv($file))) {
            if (is_null($dateTransaction)) {
                $dateTransaction = substr($data[7], 0, 10);
            }

            $hasEmptyField = false;

            for ($i=0; $i < count($data) ; $i++) { 
                if ($data[$i] == '') {
                    $hasEmptyField = true;
                }
            }

            if (!$hasEmptyField) {
                $lines[] = $data;
            }
        }

        $result = DB::table('transacoes')->where('data', $dateTransaction)->first('data');

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

        foreach ($lines as $line) {    
            if (substr($line[7], 0, 10) === $dateTransaction) {
                $transaction = new Transaction();
                $transaction->banco_origem      = $line[0];
                $transaction->agencia_origem    = $line[1];
                $transaction->conta_origem      = $line[2];
                $transaction->banco_destino     = $line[3];
                $transaction->agencia_destino   = $line[4];
                $transaction->conta_destino     = $line[5];
                $transaction->valor             = $line[6];
                $transaction->data              = $dateTransaction;
                $transaction->hora              = substr($line[7], 11, 19);
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

        return view('transactions.details', compact('record', 'transactions'));
    }
}
