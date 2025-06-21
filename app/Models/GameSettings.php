<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameSettings extends Model
{
    public $timestamps = false;

    protected $table = 'gamesettings';

    protected $primaryKey = 'Id';

    protected $fillable = [
        'GameInstanceId',
        'ConfigKey',
        'ConfigValue',
    ];

    public function gameInstanceId(): BelongsTo
    {
        return $this->belongsTo(GameInstance::class, 'GameInstanceId', 'Id');
    }
}
