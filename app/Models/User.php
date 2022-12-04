<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'usuarios';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'admin' => 'boolean',
    ];

    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
