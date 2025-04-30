<?php
namespace App\Application\DTOs;

use Carbon\Carbon;

/**
 * @OA\Schema(
 *     schema="ProgrammingGameDTO",
 *     type="object",
 *     title="Programming Game DTO",
 *     description="Data transfer object for a programming game",
 *     @OA\Property(property="GameInstancesId", type="integer", description="ID of the game instance"),
 *     @OA\Property(property="ProgrammerId", type="integer", description="ID of the programmer"),
 *     @OA\Property(property="Name", type="string", description="Name of the programming game"),
 *     @OA\Property(property="Activated", type="boolean", description="Whether the game is activated"),
 *     @OA\Property(property="StartTime", type="string", description="Start time of the game in 'Y/m/d H:i' format", example="2025/10/01 12:00"),
 *     @OA\Property(property="EndTime", type="string", description="End time of the game in 'Y/m/d H:i' format", example="2025/10/01 14:00"),
 *     @OA\Property(property="Attempts", type="integer", description="Number of attempts allowed"),
 *     @OA\Property(property="MaximumTime", type="integer", description="Maximum time allowed in seconds")
 * )
 */
class ProgrammingGameDTO
{
    public int $GameInstancesId;
    public int $ProgrammerId;
    public string $Name;
    public bool $Activated;
    public string $StartTime;
    public string $EndTime;
    public int $Attempts;
    public int $MaximumTime;

    public function __construct($data)
    {
        $this->GameInstancesId = $data["GameInstancesId"];
        $this->ProgrammerId = $data["ProgrammerId"];
        $this->Name = $data["Name"];
        $this->Activated = $data["Activated"];
        $this->StartTime = $this->formatDate($data["StartTime"]);
        $this->EndTime = $this->formatDate($data["EndTime"]);
        $this->Attempts = $data["Attempts"];
        $this->MaximumTime = $data["MaximumTime"];
    }

    private function formatDate($date): string
    {
        if ($date instanceof \DateTimeInterface) {
            return $date->format('Y/m/d H:i');
        }

        return Carbon::parse($date)->format('Y/m/d H:i');
    }
}
