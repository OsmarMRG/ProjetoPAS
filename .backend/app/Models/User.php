<?php

namespace App\Models;

use App\Models\Camera;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'contas_utilizador';
    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $fillable = ['username', 'email', 'password_hash'];

     protected $hidden = ['password_hash'];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function getRememberToken() { return null; }
    public function setRememberToken($value) {}
    public function getRememberTokenName() { return null; }

    public function cameras()
    {
        return $this->belongsToMany(
            Camera::class,
            'user_camaras',
            'user_id',
            'camera_id',
            'user_id',
            'id' 
        );
    }
}
