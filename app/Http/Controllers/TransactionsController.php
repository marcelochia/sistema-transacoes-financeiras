<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index()
    {
        return view('transactions.index');
    }

    public function store(Request $request)
    {
        $csvFile = $request->file('csvfile');
        $file = fopen($csvFile, "r");
        $transactions = [];
        $transaction = [];

        while (($data = fgetcsv($file))) {
            $transaction['source_bank'      ] = $data[0];
            $transaction['source_agency'    ] = $data[1];
            $transaction['source_account'   ] = $data[2];
            $transaction['destiny_bank'     ] = $data[3];
            $transaction['destiny_agency'   ] = $data[4];
            $transaction['destiny_account'  ] = $data[5];
            $transaction['value'            ] = $data[6];
            $transaction['date_time'        ] = $data[7];

            $transactions[] = $transaction;
        }
        dd($transactions);
    }
}
