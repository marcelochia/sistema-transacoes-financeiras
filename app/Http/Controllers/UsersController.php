<?php

namespace App\Http\Controllers;

use App\Mail\UserCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function index()
    {
        $authUserId = Auth::id();
        $users = User::where('admin', 0)->orderBy('name')->get();
        $userRemoved = session('success.removed');

        return view('users.index', compact('users', 'authUserId', 'userRemoved'));
    }

    public function create()
    {
        $invalidEmail = session('error.email');
        $created = session('success.created');

        return view('users.create', ['title' => 'Cadastrar usuário'])
            ->with('error', $invalidEmail)
            ->with('created', $created);
    }

    public function edit(User $user)
    {
        $invalidEmail = session('error.email');
        return view('users.edit', [
            'user' => $user,
            'title' => 'Editar usuário'
        ])->with('invalidEmail', $invalidEmail);
    }

    public function store(Request $request)
    {
        $basepass = '1234567890';
        $password = str_shuffle($basepass);
        $password = substr($password, 0, 6);

        $emailExists = DB::table('usuarios')->where('email', $request->email)->value('email');

        if (!is_null($emailExists)) {
            return to_route('users.create')->with('error.email', 'O e-mail informado já foi utilizado.');
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = password_hash($password, PASSWORD_BCRYPT);
        $user->save();

        $message = new UserCreated($password);

        Mail::to($user)->send(($message));
        
        return to_route('users.create')->with('success.created', 'Usuário cadastrado com sucesso.');
    }

    public function update(User $user, Request $request)
    {
        $emailExists = DB::table('usuarios')
            ->where('email', $request->email)
            ->where('id', '<>', $user->id)
            ->value('email');

            // dd($emailExists);

        if (!is_null($emailExists)) {
            return to_route('users.edit', $user)
                ->with('error.email', 'O e-mail informado já foi utilizado.');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return to_route('users.index');
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->header('X-ID'));
        $userName = $user->name;
        $user->delete();

        return to_route('users.index')->with('success.removed', "Usuário $userName removido com sucesso.");
    }
}
