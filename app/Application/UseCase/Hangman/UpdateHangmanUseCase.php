<?php
namespace App\Application\UseCase\Hangman;

use App\Application\DTOs\HangmanDTO;
use App\Application\Mappers\HangmanMapper;
use App\Domain\Entities\Hangman;
use App\Domain\Repositories\HangmanRepository;

class UpdateHangmanUseCase
{
    public function __construct(
        private HangmanRepository $repository,
    ) {}

    public function execute(int $id, HangmanDTO $dto): Hangman
    {
        $hangman = $this->repository->getHangmanById($id);
        if (!$hangman) {
            throw new \RuntimeException("Hangman not found for ID: $id");
        }

        // Assuming HangmanMapper::toEntity() can handle partial updates
        $updatedHangman = HangmanMapper::toEntity($dto);
        return $this->repository->updateHangman($id, HangmanMapper::toArray($updatedHangman));
    }
}