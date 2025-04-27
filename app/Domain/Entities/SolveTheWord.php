<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="SolveTheWord",
 *     type="object",
 *     required={"game_instance_id", "rows", "cols"},
 *     @OA\Property(
 *         property="game_instance_id",
 *         type="integer",
 *         example=1001,
 *         description="The ID of the associated game instance"
 *     ),
 *     @OA\Property(
 *         property="rows",
 *         type="integer",
 *         example=5,
 *         description="The number of rows in the puzzle"
 *     ),
 *     @OA\Property(
 *         property="cols",
 *         type="integer",
 *         example=5,
 *         description="The number of columns in the puzzle"
 *     ),
 *     @OA\Property(
 *         property="game_instances",
 *         type="object",
 *         ref="#/components/schemas/GameInstances",
 *         description="The associated game instance for this puzzle"
 *     ),
 *     @OA\Property(
 *         property="words",
 *         type="array",
 *         items={
 *             "type": "object",
 *             "properties": {
 *                 "word": {
 *                     "type": "string",
 *                     "example": "HELLO",
 *                     "description": "A word in the word puzzle"
 *                 }
 *             }
 *         },
 *         description="The list of words in the puzzle"
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
        'GameInstanceId' => GameInstances::class,
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
