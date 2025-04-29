<?php
namespace App\Application\DTOs;


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
