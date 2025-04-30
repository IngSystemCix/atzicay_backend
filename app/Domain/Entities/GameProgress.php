<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="GameProgress",
 *     type="object",
 *     required={"id", "gameSessionId", "progress"},
 *     @OA\Property(
 *         property="Id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="GameSessionId",
 *         type="integer",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="Progress",
 *         type="string",
 *         example="Level 1 completed"
 *     )
 *)
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
        'GameSessionId' => 'integer',
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
