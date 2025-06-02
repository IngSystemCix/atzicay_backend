<?php
namespace App\Application\UseCase\Hangman;

use App\Domain\Repositories\HangmanRepository;

class GetAllHangmanUseCase
{
    public function __construct(
        private HangmanRepository $repository,
    ) {}

    public function execute($id): array
    {
        return $this->repository->getAllHangmanByUserId($id);
    }
}