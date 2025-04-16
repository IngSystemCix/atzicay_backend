<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Orientation;
use Illuminate\Database\Eloquent\Model;

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
