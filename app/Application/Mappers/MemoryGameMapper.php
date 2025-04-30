<?php
namespace App\Application\Mappers;

use App\Application\DTOs\MemoryGameDTO;
use App\Domain\Entities\MemoryGame;

class MemoryGameMapper {
    public static function toEntity(MemoryGameDTO $dto): MemoryGame {
        return new MemoryGame([
            'GameInstanceId' => $dto->GameInstanceId,
            'Mode' => $dto->Mode,
            'PathImg1'=> $dto->PathImg1,
            'PathImg2'=> $dto->PathImg2,
            'DescriptionImg'=> $dto->DescriptionImg
        ]);
    }

    public static function toDTO(MemoryGame $memoryGame): MemoryGameDTO {
        return new MemoryGameDTO([
            'GameInstanceId' => $memoryGame->GameInstanceId,
            'Mode' => $memoryGame->Mode,
            'PathImg1'=> $memoryGame->PathImg1,
            'PathImg2'=> $memoryGame->PathImg2,
            'DescriptionImg'=> $memoryGame->DescriptionImg
        ]);
    }

    public static function toArray(MemoryGame $memoryGame): array {
        return [
            'Id' => $memoryGame->Id,
            'GameInstanceId' => $memoryGame->GameInstanceId,
            'Mode' => $memoryGame->Mode,
            'PathImg1'=> $memoryGame->PathImg1,
            'PathImg2'=> $memoryGame->PathImg2,
            'DescriptionImg'=> $memoryGame->DescriptionImg
        ];
    }
}