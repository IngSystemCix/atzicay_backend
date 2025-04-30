<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="GameSetting",
 *     type="object",
 *     required={"Id", "GameInstanceId", "ConfigKey", "ConfigValue"},
 *     @OA\Property(
 *         property="Id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="ConfigKey",
 *         type="string",
 *         example="background_color"
 *     ),
 *     @OA\Property(
 *         property="ConfigValue",
 *         type="string",
 *         example="#FFFFFF"
 *     )
 * )
 */
class GameSetting extends Model
{
    protected $table = "GameSettings";
    protected $primaryKey = "Id";
    public $timestamps = false;

    protected $fillable = [
        'GameInstanceId',
        'ConfigKey',
        'ConfigValue'
    ];

    protected $casts = [
        'GameInstanceId' => 'integer',
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
