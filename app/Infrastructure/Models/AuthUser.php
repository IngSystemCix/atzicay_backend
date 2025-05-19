<?php

namespace App\Infrastructure\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class AuthUser extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'Users';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Email',
        'Name',
    ];

    protected $casts = [
        'Email' => 'string',
    ];

    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
