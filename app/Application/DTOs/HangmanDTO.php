<?php

namespace App\Application\DTOs;

use App\Domain\Entities\GameInstances;

/**
 * @OA\Schema(
 *     schema="HangmanDTO",
 *     type="object",
 *     required={"gameInstanceId", "word", "clue", "presentation"},
 *     @OA\Property(
 *         property="gameInstanceId",
 *         type="integer",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="word",
 *         type="string",
 *         example="Apple"
 *     ),
 *     @OA\Property(
 *         property="clue",
 *         type="string",
 *         example="Green fruit"
 *     ),
 *     @OA\Property(
 *         property="presentation",
 *         type="string",
 *         example="A"
 *     )
 * )
 */
class HangmanDTO
{
    public function __construct(
        public GameInstances $gameInstanceId,
        public string $word,
        public string $clue,
        public string $presentation,
    ){}
}
