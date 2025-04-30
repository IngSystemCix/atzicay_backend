<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\GameSetting;

interface GameSettingRepository
{
    public function getGameSettingById(int $id): GameSetting;
    public function createGameSetting(array $data): GameSetting;
    public function updateGameSetting(int $id, array $data): GameSetting;
}