<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class SolveTheWord extends Model
{
    protected $table = "SolveTheWord";
    protected $primaryKey = "GameInstanceId";
    public $timestamps = false;
    protected $fillable = [
        'GameInstanceId',
        'Rows',
        'Cols',
    ];

    protected $casts = [
        'GameInstanceId' => GameInstances::class,
        'Rows' => 'integer',
        'Cols' => 'integer',
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

    /**
     * Relationship with the Words entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function words()
    {
        return $this->hasMany(Words::class, 'SolveTheWordId', 'GameInstanceId');
    }
}
