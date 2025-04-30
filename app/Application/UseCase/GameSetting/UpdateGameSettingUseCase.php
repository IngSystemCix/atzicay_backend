<?php
namespace App\Application\UseCase\GameSetting;

use App\Application\DTOs\GameSettingDTO;
use App\Application\Mappers\GameSettingMapper;
use App\Domain\Entities\GameSetting;
use App\Domain\Repositories\GameSettingRepository;

class UpdateGameSettingUseCase
{
    public function __construct(
        private GameSettingRepository $repository,
    ) {}

    public function execute(int $id, GameSettingDTO $dto): GameSetting
    {
        $gameSetting = $this->repository->getGameSettingById($id);
        if (!$gameSetting) {
            throw new \RuntimeException("GameSetting not found for ID: $id");
        }

        $updatedGameSetting = GameSettingMapper::toEntity($dto);
        return $this->repository->updateGameSetting($id, GameSettingMapper::toArray($updatedGameSetting));;
    }
}