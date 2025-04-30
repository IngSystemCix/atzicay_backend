<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Assessment",
 *     type="object",
 *     required={"id", "activated", "gameInstanceId", "userId", "value"},
 *     @OA\Property(
 *         property="Id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="Activated",
 *         type="boolean",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="UserId",
 *         type="integer",
 *         example=456
 *     ),
 *     @OA\Property(
 *         property="Value",
 *         type="integer",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="Comments",
 *         type="string",
 *         example="Great performance!"
 *     ),
 * )
 */
class Assessment extends Model
{
    protected $table = "Assessment";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'Activated',
        'GameInstanceId',
        'UserId',
        'Value',
        'Comments'
    ];

    protected $casts = [
        'Activated' => 'boolean',
        'GameInstanceId' => 'integer',
        'UserId' => 'integer',
        'Value' => 'integer',
        'Comments' => 'string',
    ];

    /**
     * Summary of gameInstance
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<GameInstances, Assessment>
     */
    public function gameInstance()
    {
        return $this->belongsTo(GameInstances::class, 'GameInstanceId', 'Id');
    }

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Assessment>
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'UserId', 'Id');
    }
}
