<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

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
