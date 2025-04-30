<?php
namespace App\Application\DTOs;

use App\Domain\Enums\Presentation;

/**
 * @OA\Schema(
 *     schema="HangmanDTO",
 *     type="object",
 *     title="Hangman Data Transfer Object",
 *     description="DTO for Hangman game data",
 *     required={"GameInstanceId", "Word", "Clue", "Presentation"},
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         description="The unique identifier for the game instance"
 *     ),
 *     @OA\Property(
 *         property="Word",
 *         type="string",
 *         description="The word to guess in the hangman game"
 *     ),
 *     @OA\Property(
 *         property="Clue",
 *         type="string",
 *         description="A clue for the word to guess"
 *     ),
 *     @OA\Property(
 *         property="Presentation",
 *         type="string",
 *         enum={"A", "F"},
 *         description="The presentation of the word with guessed letters revealed"
 *     )
 * )
 */
class HangmanDTO
{
    public int $GameInstanceId;
    public string $Word;
    public string $Clue;
    public Presentation $Presentation;

    public function __construct(array $data)
    {
        $this->GameInstanceId = $data['GameInstanceId'];
        $this->Word = $data['Word'];
        $this->Clue = $data['Clue'];
        $this->Presentation = Presentation::from($data['Presentation']);
    }
}