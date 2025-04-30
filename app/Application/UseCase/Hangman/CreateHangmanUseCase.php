<?php
namespace App\Application\UseCase\Hangman;

use App\Application\DTOs\HangmanDTO;
use App\Application\Mappers\HangmanMapper;
use App\Domain\Entities\Hangman;
use App\Domain\Repositories\HangmanRepository;

class CreateHangmanUseCase
{
    public function __construct(
        private HangmanRepository $repository,
    ) {}

    public function execute(HangmanDTO $dto): Hangman
    {
        $hangman = HangmanMapper::toEntity($dto);
        $this->repository->createHangman(HangmanMapper::toArray($hangman));
        return $hangman;
    }
}