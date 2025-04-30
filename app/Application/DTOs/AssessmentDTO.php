<?php
namespace App\Application\DTOs;

use App\Domain\Entities\GameInstances;
use App\Domain\Entities\User;

/**
 * @OA\Schema(
 *     schema="AssessmentDTO",
 *     type="object",
 *     required={"Activated", "GameInstanceId", "UserId", "Value"},
 *     @OA\Property(
 *         property="Activated",
 *         type="boolean",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="UserId",
 *         type="integer",
 *         example=456
 *     ),
 *     @OA\Property(
 *         property="Value",
 *         type="integer",
 *         example=5
 *     ),
 *     @OA\Property(
 *         property="Comments",
 *         type="string",
 *         example="Excellent performance."
 *     )
 * )
 */
class AssessmentDTO
{
    public bool $Activated;
    public int $GameInstanceId;
    public int $UserId;
    public int $Value;
    public string $Comments;

    public function __construct(array $data)
    {
        $this->Activated = $data['Activated'];
        $this->GameInstanceId = $data['GameInstanceId'];
        $this->UserId = $data['UserId'];
        $this->Value = $data['Value'];
        $this->Comments = $data['Comments'] ?? '';
    }
}
