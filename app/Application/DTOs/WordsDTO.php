<?php
namespace App\Application\DTOs;

use App\Domain\Enums\Orientation;

/**
 * @OA\Schema(
 *     schema="WordsDTO",
 *     type="object",
 *     title="WordsDTO",
 *     description="Data Transfer Object for Words",
 *     required={"SolveTheWordId", "Word", "Orientation"},
 *     @OA\Property(
 *         property="SolveTheWordId",
 *         type="integer",
 *         description="The ID of the word to solve"
 *     ),
 *     @OA\Property(
 *         property="Word",
 *         type="string",
 *         description="The word to be solved"
 *     ),
 *     @OA\Property(
 *         property="Orientation",
 *         type="string",
 *         description="The orientation of the word",
 *         enum={"HL", "HR", "VU", "VD", "DU", "DD"},
 *     )
 * )
 */
class WordsDTO {
    public int $SolveTheWordId;
    public string $Word;
    public Orientation $Orientation;

    public function __construct(array $data) {
        $this->SolveTheWordId = $data['SolveTheWordId'];
        $this->Word = $data['Word'];
        $this->Orientation = Orientation::from($data['Orientation']);
    }
}