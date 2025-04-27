<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Puzzle",
 *     type="object",
 *     required={"game_instance_id", "path_img", "clue", "rows", "cols", "automatic_help"},
 *     @OA\Property(
 *         property="game_instance_id",
 *         type="integer",
 *         example=1001,
 *         description="The ID of the associated game instance"
 *     ),
 *     @OA\Property(
 *         property="path_img",
 *         type="string",
 *         example="/images/puzzle.jpg",
 *         description="The path to the image for the puzzle"
 *     ),
 *     @OA\Property(
 *         property="clue",
 *         type="string",
 *         example="This is a famous landmark.",
 *         description="A clue to help solve the puzzle"
 *     ),
 *     @OA\Property(
 *         property="rows",
 *         type="integer",
 *         example=4,
 *         description="The number of rows in the puzzle grid"
 *     ),
 *     @OA\Property(
 *         property="cols",
 *         type="integer",
 *         example=4,
 *         description="The number of columns in the puzzle grid"
 *     ),
 *     @OA\Property(
 *         property="automatic_help",
 *         type="boolean",
 *         example=true,
 *         description="Whether automatic help is enabled for the puzzle"
 *     ),
 *     @OA\Property(
 *         property="game_instances",
 *         type="object",
 *         ref="#/components/schemas/GameInstances",
 *         description="The associated game instance for this puzzle"
 *     )
 * )
 */
class Puzzle extends Model
{
    protected $table = "Puzzle";
    protected $primaryKey = "GameInstanceId";
    public $timestamps = false;

    protected $fillable = [
        'GameInstanceId',
        'PathImg',
        'Clue',
        'Rows',
        'Cols',
        'automaticHelp',
    ];

    protected $casts = [
        'GameInstanceId' => GameInstances::class,
        'PathImg' => 'string',
        'Clue' => 'string',
        'Rows' => 'integer',
        'Cols' => 'integer',
        'automaticHelp' => 'boolean',
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
