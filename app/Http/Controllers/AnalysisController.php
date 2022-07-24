<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    private float $transactionValue;
    private float $accountValue;
    private float $agencyValue;

    public function __construct() {
        $this->transactionValue =       100_000;
        $this->accountValue     =     1_000_000;
        $this->agencyValue      = 1_000_000_000;
    }

    public function index(Request $request)
    {
        $records = DB::select("SELECT DISTINCT DATE_FORMAT(data_transacao, '%Y-%m') date FROM registros");
        $competence = $request->query('competence');
        $transactions = [];
        $accounts = [];
        $agencies = [];
        $suspectTransactions = false;

        if (!is_null($competence)) {
            $suspectTransactions = true;
            $transactions = $this->transactions($competence);
            $accounts = $this->accounts($competence);
            $agencies = $this->agencies($competence);
        }

        return view('analysis.index', [
            'dates' => $records,
            'suspectTransactions' => $suspectTransactions,
            'transactions' => $transactions,
            'accounts' => $accounts,
            'agencies' => $agencies
        ]);
    }

    private function transactions(string $competence)
    {
        $records = Record::where('data_transacao', 'like', "$competence%")->get();

        foreach ($records as $record) {
            $transactions = DB::table('transacoes')
                                ->select('banco_origem', 'agencia_origem', 'conta_origem', 
                                         'banco_destino', 'agencia_destino', 'conta_destino',
                                         'data', 'hora', 'valor')
                                ->where('registro_id', '=', $record->id)
                                ->where('valor', '>=', $this->transactionValue)
                                ->get();
        }

        return $transactions;
    }

    private function accounts(string $competence)
    {
        $records = Record::where('data_transacao', 'like', "$competence%")->get();

        foreach ($records as $record) {
            $accounts = DB::select("SELECT 'saida' type, banco_origem bank, agencia_origem agency, conta_origem account, SUM(valor) value
                                      FROM transacoes
                                     WHERE registro_id = $record->id
                                     GROUP BY banco_origem, agencia_origem, conta_origem
                                    HAVING SUM(valor) >= $this->accountValue
                                     UNION ALL
                                    SELECT 'entrada' type, banco_destino bank, agencia_destino agency, conta_destino account, SUM(valor) value
                                      FROM transacoes
                                     WHERE registro_id = $record->id
                                     GROUP BY banco_destino, agencia_destino, conta_destino
                                    HAVING SUM(valor) >= $this->accountValue");
        }
        
        return $accounts;
    }

    private function agencies(string $competence)
    {
        $records = Record::where('data_transacao', 'like', "$competence%")->get();

        foreach ($records as $record) {
            $accounts = DB::select("SELECT 'saida' type, banco_origem bank, agencia_origem agency, SUM(valor) value
                                      FROM transacoes
                                     WHERE registro_id = $record->id
                                     GROUP BY banco_origem, agencia_origem
                                    HAVING SUM(valor) >= $this->agencyValue
                                     UNION ALL
                                    SELECT 'entrada' type, banco_destino bank, agencia_destino agency, SUM(valor) value
                                      FROM transacoes
                                     WHERE registro_id = $record->id
                                     GROUP BY banco_destino, agencia_destino
                                    HAVING SUM(valor) >= $this->agencyValue");
        }
        
        return $accounts;
    }
}
