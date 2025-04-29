<?php
namespace App\Application\Mappers;

use App\Domain\Entities\SolveTheWord;
use App\Application\DTOs\SolveTheWordDTO;

class SolveTheWordMapper {
    public static function toEntity(SolveTheWordDTO $dto): SolveTheWord {
        return new SolveTheWord([
            'GameInstanceId'=> $dto->gameInstanceId,
            'Rows'=> $dto->rows,
            'Cols'=> $dto->cols,   
        ]);
    }
    public static function toDTO (SolveTheWord $solveTheWord): SolveTheWordDTO {
        return new SolveTheWordDTO(
            gameInstanceId: $solveTheWord->GameInstanceId,
            rows: $solveTheWord->Rows,
            cols: $solveTheWord->Cols
        );
    }
}