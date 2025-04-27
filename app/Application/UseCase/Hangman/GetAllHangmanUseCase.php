<?php
namespace App\Application\UseCase\Hangman;

use App\Domain\Repositories\HangmanRepository;

class GetAllHangmanUseCase{
    public function __construct(
        private HangmanRepository $hangmanRepository
    ){}
    public function execute(): array{
        return $this->repository->getAllHangman();
    }
}
    