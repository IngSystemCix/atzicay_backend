<?php
namespace App\Application\DTOs;

/**
 * @OA\Schema(
 *     schema="GameSettingDTO",
 *     type="object",
 *     title="Game Setting DTO",
 *     description="Data transfer object for game settings",
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         description="The ID of the game instance"
 *     ),
 *     @OA\Property(
 *         property="ConfigKey",
 *         type="string",
 *         description="The configuration key"
 *     ),
 *     @OA\Property(
 *         property="ConfigValue",
 *         type="string",
 *         description="The configuration value"
 *     )
 * )
 */
class GameSettingDTO
{
    public int $GameInstanceId;
    public string $ConfigKey;
    public string $ConfigValue;

    public function __construct(array $data) {
        $this->GameInstanceId = $data['GameInstanceId'];
        $this->ConfigKey = $data['ConfigKey'];
        $this->ConfigValue = $data['ConfigValue'];
    }
}