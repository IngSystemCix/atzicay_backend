<?php
namespace App\Application\Mappers;

use App\Application\DTOs\GameSettingDTO;
use App\Domain\Entities\GameSetting;

class GameSettingMapper
{
    public static function toEntity(GameSettingDTO $dto): GameSetting
    {
        return new GameSetting([
            'GameInstanceId' => $dto->GameInstanceId,
            'ConfigKey' => $dto->ConfigKey,
            'ConfigValue' => $dto->ConfigValue,
        ]);
    }

    public static function toDTO(GameSetting $gameSetting): GameSettingDTO
    {
        return new GameSettingDTO([
            'GameInstanceId' => $gameSetting->GameInstanceId,
            'ConfigKey' => $gameSetting->ConfigKey,
            'ConfigValue' => $gameSetting->ConfigValue,
        ]);
    }

    public static function toArray(GameSetting $gameSetting): array
    {
        return [
            'GameInstanceId' => $gameSetting->GameInstanceId,
            'ConfigKey' => $gameSetting->ConfigKey,
            'ConfigValue' => $gameSetting->ConfigValue,
        ];
    }
}