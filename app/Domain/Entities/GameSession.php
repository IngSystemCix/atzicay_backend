<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="GameSession",
 *     type="object",
 *     required={"id", "programming_game_id", "student_id", "duration", "won", "date_game"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="programming_game_id",
 *         type="integer",
 *         example=101,
 *         description="The ID of the programming game associated with this game session"
 *     ),
 *     @OA\Property(
 *         property="student_id",
 *         type="integer",
 *         example=202,
 *         description="The ID of the student participating in this game session"
 *     ),
 *     @OA\Property(
 *         property="duration",
 *         type="integer",
 *         example=30,
 *         description="The duration of the game session in minutes"
 *     ),
 *     @OA\Property(
 *         property="won",
 *         type="boolean",
 *         example=true,
 *         description="Indicates if the player won the game session"
 *     ),
 *     @OA\Property(
 *         property="date_game",
 *         type="string",
 *         format="date-time",
 *         example="2025-04-25T14:30:00Z",
 *         description="The date and time when the game session took place"
 *     ),
 *     @OA\Property(
 *         property="programming_game",
 *         type="object",
 *         ref="#/components/schemas/ProgrammingGame",
 *         description="The associated programming game for this session"
 *     ),
 *     @OA\Property(
 *         property="player",
 *         type="object",
 *         ref="#/components/schemas/User",
 *         description="The student who participated in this game session"
 *     ),
 *     @OA\Property(
 *         property="game_progress",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/GameProgress"),
 *         description="The game progress records associated with this session"
 *     )
 * )
 */
class GameSession extends Model
{
    protected $table = "GameSessions";
    protected $primarykey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'ProgrammingGameId',
        'StudentId',
        'Duration',
        'Won',
        'DateGame'
    ];

    protected $casts = [
        'ProgrammingGameId' => ProgrammingGame::class,
        'StudentId' => User::class,
        'Duration' => 'integer',
        'Won' => 'boolean',
        'DateGame' => 'datetime'
    ];
    
    /**
     * Relationship with the ProgrammingGame entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'StudentId', 'Id');
    }

    /**
     * Relationship with the ProgrammingGame entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function programmingGame()
    {
        return $this->belongsTo(ProgrammingGame::class, 'ProgrammingGameId', 'Id');
    }

    /**
     * Relationship with the Assessment entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gameProgress() {
        return $this->hasMany(GameProgress::class, 'GameSessionId', 'Id');
    }
}
