<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hangman extends Model
{
    public $timestamps = false;

    protected $table = 'hangman';

    protected $primaryKey = 'Id';

    protected $fillable = [
        'GameInstanceId',
        'Word',
        'Clue',
        'Presentation',
    ];

    public function gameInstanceId(): BelongsTo
    {
        return $this->belongsTo(GameInstance::class, 'GameInstanceId', 'Id');
    }
}
