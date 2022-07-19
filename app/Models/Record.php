<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $table = 'registros';
    protected $fillable = [
        'data_transacao',
        'user_id'
    ];
    protected $dates = [
        'data_transacao',
        'data_importacao'
    ];
    public $timestamps = false;

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
