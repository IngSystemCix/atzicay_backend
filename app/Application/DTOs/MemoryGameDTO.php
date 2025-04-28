<?php

namespace App\Application\DTOs;

use App\Domain\Entities\GameInstances;

/**
 * @OA\Schema(
 *     schema="MemoryGameDTO",
 *     type="object",
 *     required={"gameInstanceId", "mode", "pathImg1", "pathImg2", "descriptionImg"},
 *     @OA\Property(
 *         property="gameInstanceId",
 *         type="integer",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="mode",
 *         type="string",
 *         example="II"
 *     ),
 *     @OA\Property(
 *         property="pathImg1",
 *         type="string",
 *         example="MancoCapac.png"
 *     ),
 *     @OA\Property(
 *         property="pathImg2",
 *         type="string",
 *         example="MamaOcllo.png"
 *     ),
 *      @OA\Property(
 *          property="decriptionImg",
 *          property="string",
 *          property="Firt people to arrive at Macchu Pichu"
 *     )
 * )
 */
class MemoryGameDTO{
    public function __construct(
        public GameInstances $gameInstanceId,
        public string $mode,
        public string $pathImg1,
        public string $pathImg2,
        public string $descriptionImg,
    ){}
}