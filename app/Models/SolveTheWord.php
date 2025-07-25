<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SolveTheWord extends Model
{
    public $timestamps = false;

    protected $table = 'solvetheword';

    protected $primaryKey = 'GameInstanceId';

    public $incrementing = false;

    protected $fillable = [
        'GameInstanceId',
        'Rows',
        'Cols',
    ];

    public function gameInstance(): BelongsTo
    {
        return $this->belongsTo(GameInstance::class, 'GameInstanceId', 'Id');
    }

    public function words(): HasMany
    {
        return $this->hasMany(Word::class, 'SolveTheWordId', 'GameInstanceId');
    }
}
