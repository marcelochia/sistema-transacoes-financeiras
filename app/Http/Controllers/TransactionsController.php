<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransationsFormRequest;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    public function index()
    {
        $successMessage = session('success.message');

        return view('transactions.index')->with('success', $successMessage);
    }

    public function store(TransationsFormRequest $request)
    {
        $file = fopen($request->file('csvfile'), "r");

        $records = [];
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
                $records[] = $data;
            }
        }

        $result = DB::table('transacoes')->where('data', $dateTransaction)->first('data');

        if (!is_null($result)) {
            return to_route('transaction.index')
                ->with('success.message', 'Transações financeiras do dia ' . 
                                            date('d/m/Y', strtotime($dateTransaction)) . 
                                            ' já foram importadas anteriormente!');
        }

        foreach ($records as $record) {
            if (substr($record[7], 0, 10) === $dateTransaction) {
                $transaction = new Transaction();
                $transaction->banco_origem      = $record[0];
                $transaction->agencia_origem    = $record[1];
                $transaction->conta_origem      = $record[2];
                $transaction->banco_destino     = $record[3];
                $transaction->agencia_destino   = $record[4];
                $transaction->conta_destino     = $record[5];
                $transaction->valor             = $record[6];
                $transaction->data              = $dateTransaction;
                $transaction->hora              = substr($record[7], 11, 19);
                $transaction->save();
            }
        }

        return to_route('transaction.index')
            ->with('success.message', 'Transações financeiras do dia ' . 
                                        date('d/m/Y', strtotime($dateTransaction)) . 
                                        ' importadas com sucesso!');
    }
}
