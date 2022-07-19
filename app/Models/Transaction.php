<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transacoes';
    protected $fillable = [
        'banco_origem',
        'agencia_origem',
        'conta_origem',
        'banco_destino',
        'agencia_destino',
        'conta_destino',
        'valor',
        'data',
        'hora',
        'registro_id'
    ];
    public $timestamps = false;

    public function record()
    {
        return $this->belongsTo(Record::class, 'registro_id');
    }
}
