<?php
namespace App\Application\DTOs;

use App\Domain\Enums\Mode;

/**
 * @OA\Schema(
 *     schema="MemoryGameDTO",
 *     type="object",
 *     title="Memory Game DTO",
 *     description="Data transfer object for Memory Game",
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         description="The ID of the game instance"
 *     ),
 *     @OA\Property(
 *         property="Mode",
 *         type="string",
 *         description="The mode of the game",
 *         enum={"II", "ID"}
 *     ),
 *     @OA\Property(
 *         property="PathImg1",
 *         type="string",
 *         description="Path to the first image"
 *     ),
 *     @OA\Property(
 *         property="PathImg2",
 *         type="string",
 *         description="Path to the second image",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="DescriptionImg",
 *         type="string",
 *         description="Description of the image",
 *         nullable=true
 *     )
 * )
 */
class MemoryGameDTO {
    public int $GameInstanceId;
    public Mode $Mode;
    public string $PathImg1;
    public ?string $PathImg2;
    public ?string $DescriptionImg;

    public function __construct(array $data) {
        $this->GameInstanceId = $data["GameInstanceId"];
        $this->Mode = Mode::from($data["Mode"]);
        $this->PathImg1 = $data["PathImg1"];
        $this->PathImg2 = $data["PathImg2"] ?? null;
        $this->DescriptionImg = $data["DescriptionImg"] ?? null;
    }
}