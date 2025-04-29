<?php
namespace App\Application\UseCase\SolveTheWord;

use App\Application\DTOs\SolveTheWordDTO;
use App\Application\Mappers\SolveTheWordMapper;
use App\Domain\Entities\SolveTheWord;
use App\Domain\Repositories\SolveTheWordRepository;

class CreateSolveTheWordUseCase{
    public function __construct(
        private SolveTheWordRepository $respository
    ){}

    public function execute(SolveTheWordDTO $dto): SolveTheWord
    {
        $solveTheWord = SolveTheWordMapper::toEntity($dto);
        return $this->respository->createSolveTheWord(data: $solveTheWord->toArray());
    }
}