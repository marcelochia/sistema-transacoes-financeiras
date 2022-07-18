<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\Authenticator;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return to_route('login.login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.action');
Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');

Route::middleware(Authenticator::class)->group(function () {
    Route::get('/usuarios', [UsersController::class, 'index'])->name('users.index');
    Route::get('/usuarios/novo', [UsersController::class, 'create'])->name('users.create');
    Route::get('/usuarios/{user}/editar', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/usuarios/{user}/update', [UsersController::class, 'update'])->name('users.update');
    Route::post('/usuarios/salvar', [UsersController::class, 'store'])->name('users.store');
    Route::delete('/usuarios/remover', [UsersController::class, 'destroy'])->name('users.destroy');
    
    Route::get('/transacoes', [TransactionsController::class, 'index'])->name('transaction.index');
    Route::post('/transacoes', [TransactionsController::class, 'store'])->name('transaction.store');
});
