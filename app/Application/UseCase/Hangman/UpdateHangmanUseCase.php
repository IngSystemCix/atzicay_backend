<?php
namespace App\Application\UseCase\Hangman;

use App\Application\DTOs\HangmanDTO;
use App\Application\Mappers\HangmanMapper;
use App\Domain\Entities\Hangman;
use App\Domain\Repositories\HangmanRepository;

class UpdateHangmanUseCase {
    public function __construct(
        private HangmanRepository $repository
    ) {}
    
    public function execute(int $id, HangmanDTO $data): Hangman {
        $hangman = $this->repository->getHangmanById($id);
        if (!$hangman) {
            throw new \RuntimeException("Hangman not found for ID: $id");
        }

        // Map the DTO to the entity
        $updateHangman = HangmanMapper::toEntity($data);
        return $this->repository->updateHangman($id, $updateHangman->toArray());
    }
}

