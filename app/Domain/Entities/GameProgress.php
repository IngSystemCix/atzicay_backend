<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

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
