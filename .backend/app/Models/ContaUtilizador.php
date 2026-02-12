<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class ContaUtilizador extends Authenticatable
{
    use HasApiTokens;
    protected $table = 'contas_utilizador';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'status',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];
}
