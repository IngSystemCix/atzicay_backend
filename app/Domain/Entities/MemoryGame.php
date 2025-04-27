<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Mode;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="MemoryGame",
 *     type="object",
 *     required={"id", "game_instance_id", "mode", "path_img1", "path_img2", "description_img"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="game_instance_id",
 *         type="integer",
 *         example=101,
 *         description="The ID of the associated game instance"
 *     ),
 *     @OA\Property(
 *         property="mode",
 *         type="string",
 *         enum={"easy", "medium", "hard"},
 *         description="The mode of the MemoryGame",
 *         example="medium"
 *     ),
 *     @OA\Property(
 *         property="path_img1",
 *         type="string",
 *         example="path/to/img1.jpg",
 *         description="The path to the first image"
 *     ),
 *     @OA\Property(
 *         property="path_img2",
 *         type="string",
 *         example="path/to/img2.jpg",
 *         description="The path to the second image"
 *     ),
 *     @OA\Property(
 *         property="description_img",
 *         type="string",
 *         example="A description of the images shown in the memory game",
 *         description="Description of the images used in the game"
 *     ),
 *     @OA\Property(
 *         property="game_instance",
 *         type="object",
 *         ref="#/components/schemas/GameInstances",
 *         description="The associated game instance for this MemoryGame"
 *     )
 * )
 */
class MemoryGame extends Model
{
    protected $table = "MemoryGame";
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'GameInstanceId',
        'Mode',
        'PathImg1',
        'PathImg2',
        'DescriptionImg'
    ];

    protected $casts = [
        'GameInstanceId' => GameInstances::class,
        'Mode' => Mode::class,
        'PathImg1' => 'string',
        'PathImg2' => 'string',
        'DescriptionImg' => 'string',
    ];

    /**
     * Relationship with the GameInstances entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gameInstance()
    {
        return $this->belongsTo(GameInstances::class, 'GameInstanceId', 'Id');
    }
}
