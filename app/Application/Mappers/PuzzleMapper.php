<?php
namespace App\Application\Mappers;

use App\Application\DTOs\PuzzleDTO;
use App\Domain\Entities\Puzzle;

class PuzzleMapper {
    public static function toEntity(PuzzleDTO $dto): Puzzle {
        return new Puzzle([
            'GameInstanceId' => $dto->GameInstanceId,
            'PathImg' => $dto->PathImg,
            'Clue' => $dto->Clue,
            'Rows' => $dto->Rows,
            'Cols' => $dto->Cols,
            'AutomaticHelp' => $dto->AutomaticHelp,
        ]);
    }

    public static function toDTO(Puzzle $puzzle): PuzzleDTO {
        return new PuzzleDTO([
            'GameInstanceId' => $puzzle->GameInstanceId,
            'PathImg' => $puzzle->PathImg,
            'Clue' => $puzzle->Clue,
            'Rows' => $puzzle->Rows,
            'Cols' => $puzzle->Cols,
            'AutomaticHelp' => $puzzle->AutomaticHelp,
        ]);
    }

    public static function toArray(Puzzle $puzzle): array {
        return [
            'GameInstanceId' => $puzzle->GameInstanceId,
            'PathImg' => $puzzle->PathImg,
            'Clue' => $puzzle->Clue,
            'Rows' => $puzzle->Rows,
            'Cols' => $puzzle->Cols,
            'AutomaticHelp' => $puzzle->AutomaticHelp,
        ];
    }
}