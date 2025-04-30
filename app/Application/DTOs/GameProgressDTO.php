<?php
namespace App\Application\DTOs;

/**
 * @OA\Schema(
 *     schema="GameProgressDTO",
 *     type="object",
 *     title="Game Progress DTO",
 *     description="Data transfer object for game progress",
 *     @OA\Property(
 *         property="GameSessionId",
 *         type="integer",
 *         description="The ID of the game session"
 *     ),
 *     @OA\Property(
 *         property="Progress",
 *         type="string",
 *         description="The progress of the game session"
 *     )
 * )
 */
class GameProgressDTO {
    public int $GameSessionId;
    public string $Progress;

    public function __construct(array $data) {
        $this->GameSessionId = $data["GameSessionId"];
        $this->Progress = $data["Progress"];
    }
}