<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
