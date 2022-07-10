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

        dd($csvFile->getClientOriginalName(), ($csvFile->getSize() / 1024 / 1024 ));
    }
}
