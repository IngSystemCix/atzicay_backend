<?php

namespace App\Application\Mappers;

use App\Application\DTOs\HangmanDTO;
use App\Domain\Entities\Hangman;

class HangmanMapper {
    public static function toEntity (HangmanDTO $dto): Hangman {
        return new Hangman([
            'GameInstanceId' => $dto->gameInstanceId,
            'Worl' => $dto->word,
            'Clue' => $dto->clue,
            'Presentation' => $dto->presentation,
        ]);
    }

    public static function toDTO (Hangman $hangman): HangmanDTO {
        return new HangmanDTO(
            gameInstanceId: $hangman->GameInstanceId,
            word: $hangman->word,
            clue: $hangman->clue,
            presentation: $hangman->presentation,
        );
    }
}