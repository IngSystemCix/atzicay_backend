<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Presentation;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Hangman",
 *     type="object",
 *     required={"id", "game_instance_id", "word", "clue", "presentation"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="game_instance_id",
 *         type="integer",
 *         example=101,
 *         description="The ID of the game instance associated with this Hangman game"
 *     ),
 *     @OA\Property(
 *         property="word",
 *         type="string",
 *         example="programming",
 *         description="The word to be guessed in the Hangman game"
 *     ),
 *     @OA\Property(
 *         property="clue",
 *         type="string",
 *         example="A computer science activity",
 *         description="A clue related to the word"
 *     ),
 *     @OA\Property(
 *         property="presentation",
 *         type="string",
 *         enum={"image", "text", "audio"},
 *         description="The presentation type for the Hangman game",
 *         example="image"
 *     ),
 *     @OA\Property(
 *         property="game_instance",
 *         type="object",
 *         ref="#/components/schemas/GameInstances",
 *         description="The associated game instance for this Hangman game"
 *     )
 * )
 */
class Hangman extends Model
{
    protected $table = "Hangman";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'InstanceID',
        'Word',
        'Clue',
        'Presentation'
    ];

    protected $casts = [
        'GameInstanceId' => GameInstances::class,
        'Word' => 'string',
        'Clue' => 'string',
        'Presentation' => Presentation::class,
    ];

    /**
     * Summary of gameInstance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<GameInstances,Hangman>
     */
    public function gameInstances()
    {
        return $this->belongsTo(GameInstances::class, 'GameInstanceId', 'Id');
    }

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relatins\BelongsTo<User,Hangman>
     */
    public function user(): mixed{
        return $this->belongsTo(User::class, 'User', 'Id');
    }
}
