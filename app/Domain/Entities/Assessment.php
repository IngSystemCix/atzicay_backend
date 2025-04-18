<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $table = "Assessment";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'Activated',
        'GameInstanceId',
        'UserId',
        'Value',
        'Comments'
    ];

    protected $casts = [
        'Activated' => 'boolean',
        'GameInstanceId' => GameInstances::class,
        'UserId' => User::class,
        'Value' => 'integer',
        'Comments' => 'string',
    ];

    /**
     * Summary of gameInstance
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<GameInstances, Assessment>
     */
    public function gameInstance()
    {
        return $this->belongsTo(GameInstances::class, 'GameInstanceId', 'Id');
    }

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Assessment>
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'UserId', 'Id');
    }
}
