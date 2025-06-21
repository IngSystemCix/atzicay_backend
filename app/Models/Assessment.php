<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
    public $timestamps = false;

    protected $table = 'assessment';

    protected $primaryKey = 'Id';

    protected $fillable = [
        'Activated',
        'GameInstanceId',
        'UserId',
        'Value',
        'Comments',
    ];

    public function gameInstanceId(): BelongsTo
    {
        return $this->belongsTo(GameInstance::class, 'GameInstanceId', 'Id');
    }

    public function userId(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserId', 'Id');
    }

    protected function casts(): array
    {
        return [
            'Activated' => 'boolean',
        ];
    }
}
