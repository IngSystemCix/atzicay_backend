<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Gender;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="User entity schema",
 *     required={"Email", "Name", "LastName", "Gender", "Country", "City", "Birthdate"},
 *     @OA\Property(property="Id", type="integer", description="Unique identifier for the user"),
 *     @OA\Property(property="Activated", type="boolean", description="Indicates if the user is activated"),
 *     @OA\Property(property="GoogleId", type="string", nullable=true, description="Google ID of the user"),
 *     @OA\Property(property="Email", type="string", format="email", description="Email address of the user"),
 *     @OA\Property(property="Name", type="string", description="First name of the user"),
 *     @OA\Property(property="LastName", type="string", description="Last name of the user"),
 *     @OA\Property(property="Gender", type="string", enum={"M", "F", "O"}, description="Gender of the user"),
 *     @OA\Property(property="CountryId", type="integer", description="Country of the user"),
 *     @OA\Property(property="City", type="string", description="City of the user"),
 *     @OA\Property(property="Birthdate", type="string", format="date", description="Birthdate of the user"),
 *     @OA\Property(property="CreatedAt", type="string", format="date-time", description="Creation timestamp of the user"),
 * )
 */
class User extends Model
{
    protected $table = "Users";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'Activated',
        'GoogleId',
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
        'GoogleId' => 'string',
        'Email' => 'string',
        'Name' => 'string',
        'LastName' => 'string',
        'Gender' => Gender::class,
        'CountryId' => 'integer',
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
        return $this->belongsTo(Country::class, 'CountryId', 'Id');
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
