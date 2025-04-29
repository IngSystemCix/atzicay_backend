<?php
namespace App\Application\DTOs;

use App\Domain\Entities\GameInstances;


/**
 * @OA\Schema(
 *     schema="SolveTheWordDTP",
 *     type="object",
 *     required={"gameInstanceId", "Rows", "Cols"},
 *     @OA\Property(
 *         property="gameInstanceId",
 *         type="integer",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="Rows",
 *         type="integer",
 *         example=7
 *     ),
 *     @OA\Property(
 *         property="Cols",
 *         type="integer",
 *         example=7
 *     ),
 * )
 */

 class SolveTheWordDTO{
    public function __construct(
        public GameInstances $gameInstanceId,
        public int $rows,
        public int $cols,
    ){}
 }