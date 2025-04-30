<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Difficulty;
use App\Domain\Enums\Visibility;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="GameInstances",
 *     type="object",
 *     required={"id", "name", "description", "professorId", "activated", "difficulty", "visibility"},
 *     @OA\Property(
 *         property="Id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="Name",
 *         type="string",
 *         example="Game Instance 1"
 *     ),
 *     @OA\Property(
 *         property="Description",
 *         type="string",
 *         example="This is a description of the game instance."
 *     ),
 *     @OA\Property(
 *         property="ProfessorId",
 *         type="integer",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="Activated",
 *         type="boolean",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="Difficulty",
 *         type="string",
 *         enum={"E", "M", "H"},
 *         example="medium"
 *     ),
 *     @OA\Property(
 *         property="Visibility",
 *         type="string",
 *         enum={"P", "R"},
 *         example="public"
 *     )
 *)
 */
class GameInstances extends Model
{
    protected $table = "GameInstances";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'Name',
        'Description',
        'ProfessorId',
        'Activated',
        'Difficulty',
        'Visibility'
    ];

    protected $casts = [
        'Name' => 'string',
        'Description' => 'string',
        'ProfessorId' => 'integer',
        'Activated' => 'boolean',
        'Difficulty' => Difficulty::class,
        'Visibility' => Visibility::class
    ];

    /**
     * Relationship with the User entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gameInstances()
    {
        return $this->belongsTo(User::class, 'ProfessorId', 'Id');
    }

    /**
     * Relationship with the ProgrammingGame entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programmingGame()
    {
        return $this->hasMany(ProgrammingGame::class, 'GameInstancesId', 'Id');
    }

    /**
     * Relationship with the GameSetting entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gameSetting()
    {
        return $this->hasMany(GameSetting::class, 'InstanceId', 'Id');
    }

    /**
     * Relationship with the MemoryGame entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function memoryGame()
    {
        return $this->hasMany(MemoryGame::class, 'GameInstanceId', 'Id');
    }

    /**
     * Relationship with the Puzzle entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hangman()
    {
        return $this->hasOne(Hangman::class,'GameInstanceId', 'Id');
    }
    
    /**
     * Relationship with the Puzzle entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function puzzle()
    {
        return $this->hasOne(Puzzle::class,'GameInstanceId', 'Id');
    }

    /**
     * Relationship with the SolveTheWord entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function solveTheWord()
    {
        return $this->hasOne(SolveTheWord::class,'GameInstanceId', 'Id');
    }

    /**
     * Relationship with the Assessment entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assessment()
    {
        return $this->hasMany(Assessment::class, 'GameInstanceId', 'Id');
    }
}
