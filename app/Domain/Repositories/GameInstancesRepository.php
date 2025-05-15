<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\GameInstances;

interface GameInstancesRepository
{
    public function getAllGameInstances(): array;
    public function getGameInstanceById(int $id): GameInstances;
    public function createGameInstance(array $data): GameInstances;
    public function updateGameInstance(int $id, array $data): GameInstances;
    public function deleteGameInstance(int $id): GameInstances;
    public function getAllGame(): array;
    public function search(array $filters): array;
}