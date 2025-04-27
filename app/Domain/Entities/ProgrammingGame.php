<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="ProgrammingGame",
 *     type="object",
 *     required={"id", "game_instances_id", "programmer_id", "name", "start_time", "end_time", "attempts", "maximum_time"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="game_instances_id",
 *         type="integer",
 *         example=1001,
 *         description="The ID of the associated game instance"
 *     ),
 *     @OA\Property(
 *         property="programmer_id",
 *         type="integer",
 *         example=101,
 *         description="The ID of the programmer who is playing the game"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Basic Programming Challenge",
 *         description="The name of the programming game"
 *     ),
 *     @OA\Property(
 *         property="start_time",
 *         type="string",
 *         format="date",
 *         example="2025-04-25",
 *         description="The start time of the game"
 *     ),
 *     @OA\Property(
 *         property="end_time",
 *         type="string",
 *         format="date",
 *         example="2025-04-25",
 *         description="The end time of the game"
 *     ),
 *     @OA\Property(
 *         property="attempts",
 *         type="integer",
 *         example=3,
 *         description="The number of attempts made by the programmer"
 *     ),
 *     @OA\Property(
 *         property="maximum_time",
 *         type="integer",
 *         example=60,
 *         description="The maximum time allowed for completing the game in seconds"
 *     ),
 *     @OA\Property(
 *         property="user",
 *         type="object",
 *         ref="#/components/schemas/User",
 *         description="The programmer (user) associated with this programming game"
 *     ),
 *     @OA\Property(
 *         property="game_instances",
 *         type="object",
 *         ref="#/components/schemas/GameInstances",
 *         description="The associated game instance for this programming game"
 *     )
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
