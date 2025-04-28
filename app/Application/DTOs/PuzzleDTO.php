<?php

namespace App\Application\DTOs;

use App\Domain\Entities\GameInstances;

/**
 * @OA\Schema(
 *     schema="MemoryGameDTO",
 *     type="object",
 *     required={"gameInstanceId", "pathImg", "clue", "rows", "cols", "automaticHelp"},
 *     @OA\Property(
 *         property="gameInstanceId",
 *         type="integer",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="pathImg",
 *         type="string",
 *         example="MacchuPicchu.png"
 *     ),
 *     @OA\Property(
 *         property="clue",
 *         type="string",
 *         example="Wonder of the world"
 *     ),
 *     @OA\Property(
 *         property="rows",
 *         type="integer",
 *         example=6
 *     ),
 *      @OA\Property(
 *          property="cols",
 *          property="integer",
 *          property=7
 *     )
 *      @OA\Property(
 *          property="automaticHelp",
 *          property="integer",
 *          property=0
 *     )
 * )
 */
class PuzzleDTO{
    public function __construct(
        public GameInstances $gameInstanceId,
        public string $pathImg,
        public string $clue,
        public string $rows,
        public string $cols,
        public string $automaticHelp,
    ){}
}