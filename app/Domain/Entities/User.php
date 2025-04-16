<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Gender;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "Users";
    protected $primarykey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'Activated',
        'GoogleId',
        'Email',
        'Name',
        'LastName',
        'Gender',
        'Country',
        'City',
        'Birthdate',
        'CreatedAt'
    ];

    protected $casts = [
        'Activated' => 'boolean',
        'GoogleId' => 'string',
        'Email' => 'string',
        'Name' => 'string',
        'LastName' => 'string',
        'Gender' => Gender::class,
        'Country' => Country::class,
        'City' => 'string',
        'Birthdate' => 'date',
        'CreatedAt' => 'datetime',
    ];

    /**
     * Relationship with the Country entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'Country', 'Id');
    }

    /**
     * Relationship with the GameInstances entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->hasMany(GameInstances::class, 'ProfessorId', 'Id');
    }

    /**
     * Relationship with the ProgrammingGame entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programmer()
    {
        return $this->hasMany(ProgrammingGame::class, 'ProgrammerId', 'Id');
    }

    /**
     * Relationship with the GameInstances entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function player()
    {
        return $this->hasMany(GameSession::class, 'StudentId', 'Id');
    }

    /**
     * Relationship with the Assessment entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assessment()
    {
        return $this->hasMany(Assessment::class, 'UserId', 'Id');
    }
}
