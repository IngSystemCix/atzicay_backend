<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="GameSetting",
 *     type="object",
 *     required={"id", "game_instance_id", "config_key", "config_value"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="game_instance_id",
 *         type="integer",
 *         example=101,
 *         description="The ID of the game instance associated with this setting"
 *     ),
 *     @OA\Property(
 *         property="config_key",
 *         type="string",
 *         example="difficulty_level",
 *         description="The key representing the configuration setting"
 *     ),
 *     @OA\Property(
 *         property="config_value",
 *         type="string",
 *         example="hard",
 *         description="The value for the configuration setting"
 *     ),
 *     @OA\Property(
 *         property="game_instance",
 *         type="object",
 *         ref="#/components/schemas/GameInstances",
 *         description="The associated game instance for this setting"
 *     )
 * )
 */
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
