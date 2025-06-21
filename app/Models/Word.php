<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Word extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $fillable = [
        'SolveTheWordId',
        'Word',
        'Orientation',
    ];

    public function solveTheWordId(): BelongsTo
    {
        return $this->belongsTo(SolveTheWord::class, 'SolveTheWordId');
    }
}
