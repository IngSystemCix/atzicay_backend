<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Orientation;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Words",
 *     type="object",
 *     title="Words",
 *     description="Words entity schema",
 *     @OA\Property(
 *         property="Id",
 *         type="integer",
 *         description="Primary key of the Words entity"
 *     ),
 *     @OA\Property(
 *         property="SolveTheWordId",
 *         type="integer",
 *         description="Foreign key referencing SolveTheWord entity"
 *     ),
 *     @OA\Property(
 *         property="Word",
 *         type="string",
 *         description="The word itself"
 *     ),
 *     @OA\Property(
 *         property="Orientation",
 *         type="string",
 *         enum={"HL", "HR", "VU", "VD", "DU", "DD"},
 *         description="Orientation of the word"
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
        'SolveTheWordId' => 'integer',
        'Word' => 'string',
        'Orientation' => Orientation::class,
    ];

    /**
     * Summary of solveTheWord
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<SolveTheWord, Words>
     */
    public function solveTheWord()
    {
        return $this->belongsTo(SolveTheWord::class, 'SolveTheWordId', 'GameInstanceId');
    }
}
