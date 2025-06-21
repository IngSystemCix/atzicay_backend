<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Puzzle extends Model
{
    public $timestamps = false;

    protected $table = 'puzzle';

    protected $primaryKey = 'GameInstanceId';

    protected $fillable = [
        'GameInstanceId',
        'PathImg',
        'Clue',
        'Rows',
        'Cols',
        'AutomaticHelp',
    ];

    public function gameInstanceId(): BelongsTo
    {
        return $this->belongsTo(GameInstance::class, 'GameInstanceId', 'Id');
    }

    protected function casts(): array
    {
        return [
            'AutomaticHelp' => 'boolean',
        ];
    }
}
