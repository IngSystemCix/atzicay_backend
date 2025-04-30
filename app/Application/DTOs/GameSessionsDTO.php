<?php
namespace App\Application\DTOs;

/**
 * @OA\Schema(
 *     schema="GameSessionsDTO",
 *     type="object",
 *     title="Game Sessions DTO",
 *     description="Data transfer object for game sessions",
 *     @OA\Property(
 *         property="ProgrammingGameId",
 *         type="integer",
 *         description="ID of the programming game"
 *     ),
 *     @OA\Property(
 *         property="StudentId",
 *         type="integer",
 *         description="ID of the student"
 *     ),
 *     @OA\Property(
 *         property="Duration",
 *         type="integer",
 *         description="Duration of the game session in seconds"
 *     ),
 *     @OA\Property(
 *         property="Won",
 *         type="boolean",
 *         description="Indicates if the game session was won"
 *     )
 * )
 */
class GameSessionsDTO {
    public int $ProgrammingGameId;
    public int $StudentId;
    public int $Duration;
    public bool $Won;
    
    public function __construct(array $data) {
        $this->ProgrammingGameId = $data['ProgrammingGameId'];
        $this->StudentId = $data['StudentId'];
        $this->Duration = $data['Duration'];
        $this->Won = $data['Won'];
    }
}