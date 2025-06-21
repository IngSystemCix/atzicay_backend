<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameProgress extends Model
{
    public $timestamps = false;

    protected $table = 'gameprogress';

    protected $primaryKey = 'Id';

    protected $fillable = [
        'GameSessionId',
        'Progress',
    ];

    public function gameSessionId(): BelongsTo
    {
        return $this->belongsTo(GameSessions::class, 'GameSessionId');
    }
}
