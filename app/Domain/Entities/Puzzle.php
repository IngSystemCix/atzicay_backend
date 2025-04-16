<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model
{
    protected $table = "Puzzle";
    protected $primaryKey = "GameInstanceId";
    public $timestamps = false;

    protected $fillable = [
        'GameInstanceId',
        'PathImg',
        'Clue',
        'Rows',
        'Cols',
        'automaticHelp',
    ];

    protected $casts = [
        'GameInstanceId' => GameInstances::class,
        'PathImg' => 'string',
        'Clue' => 'string',
        'Rows' => 'integer',
        'Cols' => 'integer',
        'automaticHelp' => 'boolean',
    ];

    /**
     * Relationship with the GameInstances entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gameInstances()
    {
        return $this->belongsTo(GameInstances::class, 'GameInstanceId', 'Id');
    }
}
