<?php

namespace App\Application\UseCase\Hangman;

use App\Application\DTOs\HangmanDTO;
use App\Application\Mappers\HangmanMapper;
use App\Domain\Entities\Hangman;
use App\Domain\Repositories\HangmanRepository;

class DeleteHangmanUseCase{
    public function __construct(
    private HangmanRepository $repository
    ){}

    public function execute(int $id): void{
        $hangman = $this->repository->getHangmanById($id);
        if(!$hangman){
            throw new \Exception("Hangman not found by ID: $id");
        }
        // Map the DTO to the entity
         $deleteHangman = HangmanMapper::toEntity($id);
        return $this->repository->deleteHangman($id, $deleteHangman->toArray());
    }
    
}