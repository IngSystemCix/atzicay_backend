<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameInstance extends Model
{
    public $timestamps = false;

    protected $table = 'gameinstances';

    protected $primaryKey = 'Id';

    protected $fillable = [
        'Name',
        'Description',
        'ProfessorId',
        'Activated',
        'Difficulty',
        'Visibility',
    ];

    public function professorId(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ProfessorId', 'Id');
    }

    // Relación con tabla hangman
    public function hangman()
    {
        return $this->hasMany(Hangman::class, 'GameInstanceId');
    }

    // Relación con tabla memorygame
    public function memorygame()
    {
        return $this->hasMany(MemoryGame::class, 'GameInstanceId');
    }

    // Relación con tabla puzzle (único registro)
    public function puzzle()
    {
        return $this->hasOne(Puzzle::class, 'GameInstanceId');
    }

    // Relación con tabla solvetheword
    public function solvetheword()
    {
        return $this->hasMany(SolveTheWord::class, 'GameInstanceId');
    }

    // Relación con tabla gamesettings
    public function gamesettings()
    {
        return $this->hasMany(GameSettings::class, 'GameInstanceId');
    }

    protected function casts(): array
    {
        return [
            'Activated' => 'boolean',
        ];
    }
}
