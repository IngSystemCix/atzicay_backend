<?php

namespace App\Application\UseCase\MemoryGame;

use App\Application\Mappers\MemoryGameMapper;
use App\Domain\Repositories\MemoryGameRepository;

class DeleteMemoryGameUseCase{
    public function __construct(
    private MemoryGameRepository $repository
    ){}

    public function execute(int $id): void{
        $memoryGame = $this->repository->getMemoryGameById($id);
        if(!$memoryGame){
            throw new \Exception("MemoryGame not found by ID: $id");
        }
        // Map the DTO to the entity
         $deleteMemoryGame = MemoryGameMapper::toEntity($id);
        return $this->repository->deleteMemoryGame($id, $deleteMemoryGame->toArray());
    }
    
}