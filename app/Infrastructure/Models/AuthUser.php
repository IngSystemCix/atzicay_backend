<?php

namespace App\Infrastructure\Models;

use App\Domain\Enums\Gender;
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
        'Activated',
        'Email',
        'Name',
        'LastName',
        'Gender',
        'CountryId',
        'City',
        'Birthdate',
        'CreatedAt'
    ];

    protected $casts = [
        'Activated' => 'boolean',
        'Email' => 'string',
        'Name' => 'string',
        'LastName' => 'string',
        'Gender' => Gender::class,
        'CountryId' => 'integer',
        'City' => 'string',
        'Birthdate' => 'date',
        'CreatedAt' => 'datetime',
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
