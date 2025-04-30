<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Puzzle",
 *     type="object",
 *     title="Puzzle",
 *     description="Puzzle entity schema",
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         description="The ID of the game instance"
 *     ),
 *     @OA\Property(
 *         property="PathImg",
 *         type="string",
 *         description="Path to the puzzle image"
 *     ),
 *     @OA\Property(
 *         property="Clue",
 *         type="string",
 *         description="Clue for the puzzle"
 *     ),
 *     @OA\Property(
 *         property="Rows",
 *         type="integer",
 *         description="Number of rows in the puzzle"
 *     ),
 *     @OA\Property(
 *         property="Cols",
 *         type="integer",
 *         description="Number of columns in the puzzle"
 *     ),
 *     @OA\Property(
 *         property="AutomaticHelp",
 *         type="boolean",
 *         description="Indicates if automatic help is enabled"
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
        'AutomaticHelp',
    ];

    protected $casts = [
        'GameInstanceId' => 'integer',
        'PathImg' => 'string',
        'Clue' => 'string',
        'Rows' => 'integer',
        'Cols' => 'integer',
        'AutomaticHelp' => 'boolean',
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
