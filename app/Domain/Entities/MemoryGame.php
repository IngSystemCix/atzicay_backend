<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Mode;
use Illuminate\Database\Eloquent\Model;

class MemoryGame extends Model
{
    protected $table = "MemoryGame";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'GameInstanceId',
        'Mode',
        'PathImg1',
        'PathImg2',
        'DescriptionImg'
    ];

    protected $casts = [
        'GameInstanceId' => GameInstances::class,
        'Mode' => Mode::class,
        'PathImg1' => 'string',
        'PathImg2' => 'string',
        'DescriptionImg' => 'string',
    ];

    /**
     * Relationship with the GameInstances entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gameInstance()
    {
        return $this->belongsTo(GameInstances::class, 'GameInstanceId', 'Id');
    }
}
