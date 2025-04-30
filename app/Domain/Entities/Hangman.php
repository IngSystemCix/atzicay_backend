<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Presentation;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Hangman",
 *     type="object",
 *     title="Hangman",
 *     description="Hangman entity schema",
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         description="The ID of the related game instance"
 *     ),
 *     @OA\Property(
 *         property="Word",
 *         type="string",
 *         description="The word to guess in the hangman game"
 *     ),
 *     @OA\Property(
 *         property="Clue",
 *         type="string",
 *         description="The clue for the word"
 *     ),
 *     @OA\Property(
 *         property="Presentation",
 *         type="string",
 *         enum={"A", "F"},
 *         description="The presentation type of the hangman game"
 *     )
 * )
 */
class Hangman extends Model
{
    protected $table = "Hangman";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'GameInstanceId',
        'Word',
        'Clue',
        'Presentation'
    ];

    protected $casts = [
        'GameInstanceId' => 'integer',
        'Word' => 'string',
        'Clue' => 'string',
        'Presentation' => Presentation::class,
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
