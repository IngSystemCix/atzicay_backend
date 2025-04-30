<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\GameProgress;

interface GameProgressRepository 
{
    public function getGameProgressById(int $id): GameProgress;
    public function createGameProgress(array $data): GameProgress;
    public function updateGameProgress(int $id, array $data): GameProgress;
}