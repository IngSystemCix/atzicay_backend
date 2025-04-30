<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="SolveTheWord",
 *     type="object",
 *     title="SolveTheWord",
 *     description="SolveTheWord entity schema",
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         description="The ID of the game instance"
 *     ),
 *     @OA\Property(
 *         property="Rows",
 *         type="integer",
 *         description="Number of rows in the game"
 *     ),
 *     @OA\Property(
 *         property="Cols",
 *         type="integer",
 *         description="Number of columns in the game"
 *     )
 * )
 */
class SolveTheWord extends Model
{
    protected $table = "SolveTheWord";
    protected $primaryKey = "GameInstanceId";
    public $timestamps = false;
    protected $fillable = [
        'GameInstanceId',
        'Rows',
        'Cols',
    ];

    protected $casts = [
        'GameInstanceId' => 'integer',
        'Rows' => 'integer',
        'Cols' => 'integer',
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

    /**
     * Relationship with the Words entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function words()
    {
        return $this->hasMany(Words::class, 'SolveTheWordId', 'GameInstanceId');
    }
}
