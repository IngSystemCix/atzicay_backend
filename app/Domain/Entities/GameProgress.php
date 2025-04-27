<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="GameProgress",
 *     type="object",
 *     required={"id", "game_session_id", "progress"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="game_session_id",
 *         type="integer",
 *         example=101,
 *         description="The ID of the game session associated with this progress"
 *     ),
 *     @OA\Property(
 *         property="progress",
 *         type="string",
 *         example="50%",
 *         description="The progress made in the game session"
 *     ),
 *     @OA\Property(
 *         property="game_session",
 *         type="object",
 *         ref="#/components/schemas/GameSession",  // Referencia al esquema GameSession
 *         description="The associated game session for this progress"
 *     )
 * )
 */
class GameProgress extends Model
{
    protected $table = "GameProgress";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'GameSessionId',
        'Progress'
    ];

    protected $casts = [
        'GameSessionId' => GameSession::class,
        'Progress' => 'string'
    ];

    /**
     * Summary of gameSession
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<GameSession, GameProgress>
     */
    public function gameSession() {
        return $this->belongsTo(GameSession::class, 'GameSessionId', 'Id');
    }
}
