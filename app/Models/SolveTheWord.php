<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function gameInstanceId(): BelongsTo
    {
        return $this->belongsTo(GameInstance::class, 'GameInstanceId', 'Id');
    }
}
