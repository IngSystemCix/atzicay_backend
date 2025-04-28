<?php

namespace App\Application\Mappers;

use App\Domain\Entities\MemoryGame;
use App\Application\DTOs\MemoryGameDTO;

class MemoryGameMapper{
    public static function toEntity(MemoryGameDTO $dto): MemoryGame{
        return new MemoryGame([
            'GameInstanceId' => $dto->gameInstanceId,
            'Mode'=> $dto->mode,
            'PathImg1'=> $dto->pathImg1,
            'PathImg2'=> $dto->pathImg2,
            'DescriptionImg'=> $dto->descriptionImg,
        ]);
    }

    public static function toDTO(MemoryGame $memoryGame): MemoryGameDTO{
        return new MemoryGameDTO(
            gameInstanceId: $memoryGame->GameInstanceId,
            mode: $memoryGame->Mode,
            pathImg1: $memoryGame->PathImg1,
            pathImg2: $memoryGame->PathImg2,
            descriptionImg: $memoryGame->DescriptionImg,
        );
    }
}