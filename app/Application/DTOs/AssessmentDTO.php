<?php
namespace App\Application\DTOs;

use App\Domain\Entities\GameInstances;
use App\Domain\Entities\User;

/**
 * @OA\Schema(
 *     schema="AssessmentDTO",
 *     type="object",
 *     required={"activated", "gameInstanceId", "userId", "value"},
 *     @OA\Property(
 *         property="activated",
 *         type="boolean",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="gameInstanceId",
 *         type="integer",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="userId",
 *         type="integer",
 *         example=456
 *     ),
 *     @OA\Property(
 *         property="value",
 *         type="integer",
 *         example=5
 *     ),
 *     @OA\Property(
 *         property="comments",
 *         type="string",
 *         example="Excellent performance."
 *     )
 * )
 */
class AssessmentDTO
{
    public function __construct(
        public bool $activated,
        public GameInstances $gameInstanceId,
        public User $userId,
        public int $value,
        public string $comments = ''
    ) {}
}