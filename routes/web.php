<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\Authenticator;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return to_route('login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.action');

Route::middleware(Authenticator::class)->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');
    
    Route::get('/usuarios', [UsersController::class, 'index'])->name('users.index');
    Route::get('/usuarios/novo', [UsersController::class, 'create'])->name('users.create');
    Route::get('/usuarios/{user}/editar', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/usuarios/{user}/update', [UsersController::class, 'update'])->name('users.update');
    Route::post('/usuarios/salvar', [UsersController::class, 'store'])->name('users.store');
    Route::delete('/usuarios/remover', [UsersController::class, 'destroy'])->name('users.destroy');
    
    Route::get('/transacoes', [TransactionsController::class, 'index'])->name('transaction.index');
    Route::post('/transacoes', [TransactionsController::class, 'store'])->name('transaction.store');
    Route::get('/transacoes/detalhes/{record}', [TransactionsController::class, 'details'])->name('transaction.details');

    Route::get('/transacoes/analise', [AnalysisController::class, 'index'])->name('analysis.index');
});
