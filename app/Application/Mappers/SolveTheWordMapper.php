<?php
namespace App\Application\Mappers;

use App\Application\DTOs\SolveTheWordDTO;
use App\Domain\Entities\SolveTheWord;

class SolveTheWordMapper {
    public static function toEntity(SolveTheWordDTO $dto): SolveTheWord {
        return new SolveTheWord([
            'GameInstanceId' => $dto->GameInstanceId,
            'Rows' => $dto->Rows,
            'Cols' => $dto->Cols,
        ]);
    }

    public static function toDTO(SolveTheWord $solveTheWord): SolveTheWordDTO {
        return new SolveTheWordDTO([
            'GameInstanceId' => $solveTheWord->GameInstanceId,
            'Rows' => $solveTheWord->Rows,
            'Cols' => $solveTheWord->Cols,
        ]);
    }

    public static function toArray(SolveTheWord $solveTheWord): array {
        return [
            'Id' => $solveTheWord->Id,
            'GameInstanceId' => $solveTheWord->GameInstanceId,
            'Rows' => $solveTheWord->Rows,
            'Cols' => $solveTheWord->Cols,
        ];
    }
}