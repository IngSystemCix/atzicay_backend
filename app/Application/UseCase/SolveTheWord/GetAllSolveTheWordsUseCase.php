<?php

namespace App\Application\UseCase\SolveTheWord;

use App\Domain\Repositories\SolveTheWordRepository;


class GetAllSolveTheWordsUseCase
{
    public function __construct(private SolveTheWordRepository $repository) {}

    /**
     * @return array
     */
    public function execute(): array
    {
        return $this->repository->getAllSolveTheWords();
    }
}