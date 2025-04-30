<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="ProgrammingGame",
 *     type="object",
 *     title="ProgrammingGame",
 *     description="Programming Game entity",
 *     @OA\Property(property="Id", type="integer", description="Primary key of the ProgrammingGame"),
 *     @OA\Property(property="GameInstancesId", type="integer", description="Foreign key to GameInstances"),
 *     @OA\Property(property="ProgrammerId", type="integer", description="Foreign key to User"),
 *     @OA\Property(property="Name", type="string", description="Name of the programming game"),
 *    @OA\Property(property="Activated", type="boolean", description="Whether the game is activated"),
 *     @OA\Property(property="StartTime", type="string", description="Start time of the game in 'Y/m/d H:i' format", example="2025/10/01 12:00"),
 *     @OA\Property(property="EndTime", type="string", description="End time of the game in 'Y/m/d H:i' format", example="2025/10/01 14:00"),
 *     @OA\Property(property="Attempts", type="integer", description="Number of attempts allowed"),
 *     @OA\Property(property="MaximumTime", type="integer", description="Maximum time allowed for the game")
 * )
 */
class ProgrammingGame extends Model
{
    protected $table = "ProgrammingGame";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'GameInstancesId',
        'ProgrammerId',
        'Name',
        'Activated',
        'StartTime',
        'EndTime',
        'Attempts',
        'MaximumTime'
    ];

    protected $casts = [
        'GameInstancesId' => 'integer',
        'ProgrammerId' => 'integer',
        'Name' => 'string',
        'Activated' => 'boolean',
        'StartTime' => 'datetime:Y/m/d H:i',
        'EndTime' => 'datetime:Y/m/d H:i',
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
