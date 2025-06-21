<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameSessions extends Model
{
    public $timestamps = false;

    protected $table = 'gamesessions';

    protected $primaryKey = 'Id';

    protected $fillable = [
        'ProgrammingGameId',
        'StudentId',
        'Duration',
        'Won',
        'DateGame',
    ];

    public function programmingGameId(): BelongsTo
    {
        return $this->belongsTo(ProgrammingGame::class, 'ProgrammingGameId');
    }

    public function studentId(): BelongsTo
    {
        return $this->belongsTo(User::class, 'StudentId', 'Id');
    }

    protected function casts(): array
    {
        return [
            'DateGame' => 'timestamp',
        ];
    }
}
