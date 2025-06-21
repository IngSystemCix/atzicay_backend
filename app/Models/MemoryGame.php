<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemoryGame extends Model
{
    public $timestamps = false;

    protected $table = 'memorygame';

    protected $primaryKey = 'Id';

    protected $fillable = [
        'GameInstanceId',
        'Mode',
        'PathImg1',
        'PathImg2',
        'DescriptionImg',
    ];

    public function gameInstanceId(): BelongsTo
    {
        return $this->belongsTo(GameInstance::class, 'GameInstanceId', 'Id');
    }
}
