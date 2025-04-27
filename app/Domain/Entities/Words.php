<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Orientation;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Words",
 *     type="object",
 *     required={"id", "solve_the_word_id", "word", "orientation"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1,
 *         description="Unique identifier for the word"
 *     ),
 *     @OA\Property(
 *         property="solve_the_word_id",
 *         type="integer",
 *         example=1,
 *         description="ID of the SolveTheWord game instance that this word belongs to"
 *     ),
 *     @OA\Property(
 *         property="word",
 *         type="string",
 *         example="example",
 *         description="The word for the game"
 *     ),
 *     @OA\Property(
 *         property="orientation",
 *         type="string",
 *         enum={"Horizontal", "Vertical"},
 *         example="Horizontal",
 *         description="The orientation of the word (Horizontal or Vertical)"
 *     )
 * )
 */
class Words extends Model
{
    protected $table = "Words";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'SolveTheWordId',
        'Word',
        'Orientation'
    ];

    protected $casts = [
        'SolveTheWordId' => SolveTheWord::class,
        'Word' => 'string',
        'Orientation' => Orientation::class,
    ];

    /**
     * Summary of solveTheWord
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<SolveTheWord, Words>
     */
    public function solveTheWord()
    {
        return $this->belongsTo(SolveTheWord::class, 'SolveTheWordId', 'Id');
    }
}
