<?php
namespace App\Application\DTOs;

use App\Domain\Enums\Difficulty;
use App\Domain\Enums\Visibility;

/**
 * @OA\Schema(
 *     schema="GameInstancesDTO",
 *     type="object",
 *     title="Game Instances DTO",
 *     description="Data transfer object for game instances",
 *     @OA\Property(
 *         property="Name",
 *         type="string",
 *         description="The name of the game instance"
 *     ),
 *     @OA\Property(
 *         property="Description",
 *         type="string",
 *         description="The description of the game instance"
 *     ),
 *     @OA\Property(
 *         property="ProfessorId",
 *         type="integer",
 *         description="The ID of the professor associated with the game instance"
 *     ),
 *     @OA\Property(
 *         property="Activated",
 *         type="boolean",
 *         description="Indicates if the game instance is active"
 *     ),
 *     @OA\Property(
 *         property="Difficulty",
 *         type="string",
 *         description="The difficulty level of the game instance",
 *         enum={"E", "M", "H"}
 *     ),
 *     @OA\Property(
 *         property="Visibility",
 *         type="string",
 *         description="Indicates if the game instance is visible",
 *         enum={"P", "R"}
 *     )
 * )
 */
class GameInstancesDTO
{
    public string $Name;
    public string $Description;
    public int $ProfessorId;
    public bool $Activated;
    public Difficulty $Difficulty;
    public Visibility $Visibility;

    public function __construct(array $data)
    {
        $this->Name = $data['Name'];
        $this->Description = $data['Description'];
        $this->ProfessorId = $data['ProfessorId'];
        $this->Activated = $data['Activated'];
        $this->Difficulty = Difficulty::from($data['Difficulty']);
        $this->Visibility = Visibility::from($data['Visibility']);
    }
}