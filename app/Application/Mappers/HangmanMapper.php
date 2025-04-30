<?php
namespace App\Application\Mappers;

use App\Application\DTOs\HangmanDTO;
use App\Domain\Entities\Hangman;

class HangmanMapper {
    
    public static function toEntity(HangmanDTO $dto): Hangman {
        return new Hangman([
            'GameInstanceId' => $dto->GameInstanceId,
            'Word' => $dto->Word,
            'Clue' => $dto->Clue,
            'Presentation' => $dto->Presentation,
        ]);
    }

    public static function toDTO(Hangman $hangman): HangmanDTO {
        return new HangmanDTO([
            'GameInstanceId' => $hangman->GameInstanceId,
            'Word' => $hangman->Word,
            'Clue' => $hangman->Clue,
            'Presentation' => $hangman->Presentation,
        ]);
    }

    public static function toArray(Hangman $hangman): array {
        return [
            'Id' => $hangman->Id,
            'GameInstanceId' => $hangman->GameInstanceId,
            'Word' => $hangman->Word,
            'Clue' => $hangman->Clue,
            'Presentation' => $hangman->Presentation,
        ];
    }
}