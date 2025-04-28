<?php
namespace App\Application\Mappers;

use App\Application\DTOs\PuzzleDTO;
use App\Domain\Entities\Puzzle;

class PuzzleMapper {
    public static function toEntity(PuzzleDTO $dto): Puzzle {
        return new Puzzle([
            'GameInstanceId' => $dto->gameInstanceId,
            'PathImg' => $dto->pathImg,
            'Clue' => $dto->clue,
            'Rows' => $dto->rows,
            'Cols'=> $dto->cols,
            'AutomaticHelp'=> $dto->automaticHelp,
        ]);
    }

    public static function toDTO(Puzzle $puzzle): PuzzleDTO {
        return new PuzzleDTO(
            gameInstanceId: $puzzle->GameInstanceId,
            pathImg: $puzzle->PathImg,
            clue: $puzzle->Clue,
            rows: $puzzle->Rows,
            cols: $puzzle->Cols,
            automaticHelp: $puzzle->AutomaticHelp
        );
    }
}