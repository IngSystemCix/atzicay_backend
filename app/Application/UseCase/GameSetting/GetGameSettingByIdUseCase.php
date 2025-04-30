<?php
namespace App\Application\UseCase\GameSetting;

use App\Domain\Entities\GameSetting;
use App\Domain\Repositories\GameSettingRepository;

class GetGameSettingByIdUseCase
{
    public function __construct(
        private GameSettingRepository $repository
    ) {}

    public function execute(int $id): GameSetting
    {
        $gameSetting = $this->repository->getGameSettingById($id);
        if (!$gameSetting) {
            throw new \RuntimeException("GameSetting not found for ID: $id");
        }
        return $gameSetting;
    }
}