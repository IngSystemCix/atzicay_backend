<?php
namespace App\Application\DTOs;

/**
 * @OA\Schema(
 *     schema="SolveTheWordDTO",
 *     type="object",
 *     title="SolveTheWordDTO",
 *     description="Data Transfer Object for solving the word game",
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         description="The ID of the game instance"
 *     ),
 *     @OA\Property(
 *         property="Rows",
 *         type="integer",
 *         description="The number of rows in the game"
 *     ),
 *     @OA\Property(
 *         property="Cols",
 *         type="integer",
 *         description="The number of columns in the game"
 *     )
 * )
 */
class SolveTheWordDTO {
    public int $GameInstanceId;
    public int $Rows;
    public int $Cols;

    public function __construct(array $data) {
        $this->GameInstanceId = $data["GameInstanceId"];
        $this->Rows = $data["Rows"];
        $this->Cols = $data["Cols"];
    }
}