<?php
namespace App\Application\UseCase\Assessment;

use App\Application\DTOs\HangmanDTO;
use App\Application\Mappers\HangmanMapper;
use App\Domain\Entities\Hangman;
use App\Domain\Repositories\HangmanRepository;

class CreateHangmanUseCase {
    public function __construct(
        private HangmanRepository $hangmanRepository,
    ){}
    
    public function execute(HangmanDTO $dto): Hangman{
        $hangman = HangmanMapper::toEntity($dto);
        return $this->repository->createHangman(data: $hangman->toArray());
    }
}