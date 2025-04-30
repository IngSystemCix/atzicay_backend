<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="GameSession",
 *     type="object",
 *     required={"id", "programmingGameId", "studentId", "duration", "won", "dateGame"},
 *     @OA\Property(
 *         property="Id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="ProgrammingGameId",
 *         type="integer",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="StudentId",
 *         type="integer",
 *         example=456
 *     ),
 *     @OA\Property(
 *         property="Duration",
 *         type="integer",
 *         example=30
 *     ),
 *     @OA\Property(
 *         property="Won",
 *         type="boolean",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="DateGame",
 *         type="string",
 *         format="date-time",
 *         example="2023-10-01T12:00:00Z"
 *     )
 *)
 */
class GameSession extends Model
{
    protected $table = "GameSessions";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'ProgrammingGameId',
        'StudentId',
        'Duration',
        'Won',
        'DateGame'
    ];

    protected $casts = [
        'ProgrammingGameId' => 'integer',
        'StudentId' => 'integer',
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
