<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class GameSetting extends Model
{
    protected $table = "GameSettings";
    protected $primarykey = "Id";
    public $timestamps = false;

    protected $fillable = [
        'GameInstanceId',
        'ConfigKey',
        'ConfigValue'
    ];

    protected $casts = [
        'GameInstanceId' => GameInstances::class,
        'ConfigKey' => 'string',
        'ConfigValue' => 'string'
    ];

    /**
     * Relationship with the GameInstances entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gameInstances()
    {
        return $this->belongsTo(GameInstances::class, 'GameInstanceId', 'Id');
    }
}
