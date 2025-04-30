<?php
namespace App\Application\UseCase\GameSetting;

use App\Application\DTOs\GameSettingDTO;
use App\Application\Mappers\GameSettingMapper;
use App\Domain\Entities\GameSetting;
use App\Domain\Repositories\GameSettingRepository;

class CreateGameSettingUseCase
{
    public function __construct(
        private GameSettingRepository $repository,
    ) {}

    public function execute(GameSettingDTO $dto): GameSetting
    {
        $gameSetting = GameSettingMapper::toEntity($dto);
        $this->repository->createGameSetting(GameSettingMapper::toArray($gameSetting));
        return $gameSetting;
    }
}