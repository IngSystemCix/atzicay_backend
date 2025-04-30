<?php
namespace App\Application\DTOs;

/**
 * @OA\Schema(
 *     schema="PuzzleDTO",
 *     type="object",
 *     title="PuzzleDTO",
 *     description="Data Transfer Object for Puzzle",
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         description="The ID of the game instance"
 *     ),
 *     @OA\Property(
 *         property="PathImg",
 *         type="string",
 *         description="The path to the puzzle image"
 *     ),
 *     @OA\Property(
 *         property="Clue",
 *         type="string",
 *         description="The clue for the puzzle"
 *     ),
 *     @OA\Property(
 *         property="Rows",
 *         type="integer",
 *         description="The number of rows in the puzzle"
 *     ),
 *     @OA\Property(
 *         property="Cols",
 *         type="integer",
 *         description="The number of columns in the puzzle"
 *     ),
 *     @OA\Property(
 *         property="AutomaticHelp",
 *         type="boolean",
 *         description="Indicates if automatic help is enabled"
 *     )
 * )
 */
class PuzzleDTO {
    public int $GameInstanceId;
    public string $PathImg;
    public string $Clue;
    public int $Rows;
    public int $Cols;
    public bool $AutomaticHelp;

    public function __construct(array $data) {
        $this->GameInstanceId = $data["GameInstanceId"];
        $this->PathImg = $data["PathImg"];
        $this->Clue = $data["Clue"];
        $this->Rows = $data["Rows"];
        $this->Cols = $data["Cols"];
        $this->AutomaticHelp = $data["AutomaticHelp"];
    }
}