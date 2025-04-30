<?php
namespace App\Application\Mappers;

use App\Application\DTOs\WordsDTO;
use App\Domain\Entities\Words;

class WordsMapper 
{
    public static function toEntity(WordsDTO $dto): Words
    {
        return new Words([
            'SolveTheWordId' => $dto->SolveTheWordId,
            'Word' => $dto->Word,
            'Orientation' => $dto->Orientation,
        ]);
    }

    public static function toDTO(Words $word): WordsDTO
    {
        return new WordsDTO([
            'SolveTheWordId' => $word->SolveTheWordId,
            'Word' => $word->Word,
            'Orientation' => $word->Orientation,
        ]);
    }

    public static function toArray(Words $word): array
    {
        return [
            'Id' => $word->Id,
            'SolveTheWordId' => $word->SolveTheWordId,
            'Word' => $word->Word,
            'Orientation' => $word->Orientation,
        ];
    }
}