<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $table = 'registros';
    protected $fillable = ['data_transacao'];
    protected $dates = ['data_transacao', 'data_importacao'];
    public $timestamps = false;
}
