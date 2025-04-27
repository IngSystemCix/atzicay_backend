<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Presentation;
use Illuminate\Database\Eloquent\Model;

class Hangman extends Model
{
    protected $table = "Hangman";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'InstanceID',
        'Word',
        'Clue',
        'Presentation'
    ];

    protected $casts = [
        'GameInstanceId' => GameInstances::class,
        'Word' => 'string',
        'Clue' => 'string',
        'Presentation' => Presentation::class,
    ];

    /**
     * Summary of gameInstance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<GameInstances,Hangman>
     */
    public function gameInstances()
    {
        return $this->belongsTo(GameInstances::class, 'GameInstanceId', 'Id');
    }

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relatins\BelongsTo<User,Hangman>
     */
    public function user(): mixed{
        return $this->belongsTo(User::class, 'User', 'Id');
    }
}
