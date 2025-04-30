<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\GameSetting;
use App\Domain\Repositories\GameSettingRepository;

class EloquentGameSettingRepository implements GameSettingRepository
{
    
    public function createGameSetting(array $data): GameSetting {
        return GameSetting::create([
            'GameInstanceId' => $data['GameInstanceId'],
            'ConfigKey'=> $data['ConfigKey'],
            'ConfigValue'=> $data['ConfigValue'],
        ]);
    }
    
    public function getGameSettingById(int $id): GameSetting {
        $gameSetting = GameSetting::find($id);

        if (!$gameSetting) {
            throw new \RuntimeException("GameSetting not found with ID: $id");
        }

        return $gameSetting;
    }
    
    public function updateGameSetting(int $id, array $data): GameSetting {
        $gameSetting = GameSetting::find($id);

        if (!$gameSetting) {
            throw new \RuntimeException("GameSetting not found with ID: $id");
        }
        $gameSetting->update([
            'GameInstanceId' => $data['GameInstanceId'],
            'ConfigKey'=> $data['ConfigKey'],
            'ConfigValue'=> $data['ConfigValue'],
        ]);
        return $gameSetting;
    }
}