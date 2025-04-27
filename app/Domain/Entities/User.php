<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Gender;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     required={"id", "email", "name", "last_name", "gender", "country", "city", "birthdate", "created_at"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1,
 *         description="Unique identifier for the user"
 *     ),
 *     @OA\Property(
 *         property="activated",
 *         type="boolean",
 *         example=true,
 *         description="Indicates if the user account is activated"
 *     ),
 *     @OA\Property(
 *         property="google_id",
 *         type="string",
 *         example="abc123googleid",
 *         description="Google ID associated with the user (if applicable)"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         example="user@example.com",
 *         description="Email address of the user"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="John",
 *         description="First name of the user"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         example="Doe",
 *         description="Last name of the user"
 *     ),
 *     @OA\Property(
 *         property="gender",
 *         type="string",
 *         enum={"Male", "Female", "Other"},
 *         example="Male",
 *         description="Gender of the user"
 *     ),
 *     @OA\Property(
 *         property="country",
 *         type="object",
 *         ref="#/components/schemas/Country",
 *         description="The country of the user"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         example="New York",
 *         description="City of the user"
 *     ),
 *     @OA\Property(
 *         property="birthdate",
 *         type="string",
 *         format="date",
 *         example="1990-01-01",
 *         description="Birthdate of the user"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="datetime",
 *         example="2025-04-26T12:00:00",
 *         description="The timestamp when the user account was created"
 *     )
 * )
 */
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
