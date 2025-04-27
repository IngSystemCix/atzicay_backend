<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Difficulty;
use App\Domain\Enums\Visibility;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="GameInstances",
 *     type="object",
 *     required={"id", "name", "description", "professor_id", "activated", "difficulty", "visibility"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Math Game"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="A challenging math game for students."
 *     ),
 *     @OA\Property(
 *         property="professor_id",
 *         type="integer",
 *         example=101,
 *         description="The ID of the professor who created the game"
 *     ),
 *     @OA\Property(
 *         property="activated",
 *         type="boolean",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="difficulty",
 *         type="string",
 *         enum={"easy", "medium", "hard"},
 *         example="medium",
 *         description="The difficulty level of the game"
 *     ),
 *     @OA\Property(
 *         property="visibility",
 *         type="string",
 *         enum={"public", "private"},
 *         example="public",
 *         description="The visibility of the game instance"
 *     ),
 *     @OA\Property(
 *         property="user",
 *         type="object",
 *         ref="#/components/schemas/User",  // Hace referencia al esquema User
 *         description="The professor associated with this game instance"
 *     ),
 *     @OA\Property(
 *         property="programming_game",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProgrammingGame"),
 *         description="Programming games related to this game instance"
 *     ),
 *     @OA\Property(
 *         property="game_setting",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/GameSetting"),
 *         description="Game settings related to this game instance"
 *     ),
 *     @OA\Property(
 *         property="memory_game",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/MemoryGame"),
 *         description="Memory games related to this game instance"
 *     ),
 *     @OA\Property(
 *         property="hangman",
 *         type="object",
 *         ref="#/components/schemas/Hangman",
 *         description="Hangman game related to this game instance"
 *     ),
 *     @OA\Property(
 *         property="puzzle",
 *         type="object",
 *         ref="#/components/schemas/Puzzle",
 *         description="Puzzle game related to this game instance"
 *     ),
 *     @OA\Property(
 *         property="solve_the_word",
 *         type="object",
 *         ref="#/components/schemas/SolveTheWord",
 *         description="SolveTheWord game related to this game instance"
 *     ),
 *     @OA\Property(
 *         property="assessment",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Assessment"),
 *         description="Assessments related to this game instance"
 *     )
 * )
 */
class GameInstances extends Model
{
    protected $table = "GameInstances";
    protected $primarykey = "Id";
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
        'ProfessorId' => User::class,
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
