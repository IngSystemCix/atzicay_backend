<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgrammingGame extends Model
{
    public $timestamps = false;

    protected $table = 'programminggame';

    protected $primaryKey = 'Id';

    protected $fillable = [
        'GameInstancesId',
        'ProgrammerId',
        'Name',
        'Activated',
        'StartTime',
        'EndTime',
        'Attempts',
        'MaximumTime',
    ];

    public function gameInstancesId(): BelongsTo
    {
        return $this->belongsTo(GameInstance::class, 'GameInstancesId');
    }

    public function programmerId(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ProgrammerId', 'Id');
    }

    protected function casts(): array
    {
        return [
            'Activated' => 'boolean',
            'StartTime' => 'timestamp',
            'EndTime' => 'timestamp',
        ];
    }
}
