<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class ProgrammingGame extends Model
{
    protected $table = "ProgrammingGame";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'GameInstancesId',
        'ProgrammerId',
        'name',
        'StartTime',
        'EndTime',
        'Attempts',
        'MaximumTime'
    ];

    protected $casts = [
        'GameInstancesId' => GameInstances::class,
        'ProgrammerId' => User::class,
        'name' => 'string',
        'StartTime' => 'date',
        'EndTime' => 'date',
        'Attempts' => 'integer',
        'MaximumTime' => 'integer'
    ];

    /**
     * Relationship with the User entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'ProgrammerId', 'Id');
    }

    /**
     * Relationship with the GameInstances entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gameInstances()
    {
        return $this->belongsTo(GameInstances::class, 'GameInstancesId', 'Id');
    }

    /**
     * Relationship with the GameSetting entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gameSession()
    {
        return $this->hasMany(GameSession::class, 'ProgrammingGameId', 'Id');
    }
}
