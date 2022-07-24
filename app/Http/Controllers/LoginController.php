<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return to_route('transaction.index');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email,'password' => $request->password])) {
            return redirect()->back()->withErrors('Usuário ou senha inválidos');
        }

        return to_route('transaction.index');
    }

    public function logout()
    {
        Auth::logout();

        return to_route('login');
    }
}
