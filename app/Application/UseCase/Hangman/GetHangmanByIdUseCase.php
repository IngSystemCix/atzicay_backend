<?php

namespace App\Application\UseCase\Hangman;

use App\Domain\Entities\Hangman;
use App\Domain\Repositories\HangmanRepository;

class GetHangmanByIdUseCase {
    public function __construct(
        private HangmanRepository $repository
    ){}

    public function execute(int $id): Hangman{

        $hangman = $this->repository->getHangmanById($id);

        if(!$hangman){
            throw new \RuntimeException("Hangman not found for ID: $id");
        }
        return $hangman;
    }
}