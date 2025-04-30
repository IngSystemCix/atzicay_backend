<?php

namespace App\Domain\Entities;

use App\Domain\Enums\Mode;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="MemoryGame",
 *     type="object",
 *     title="MemoryGame",
 *     description="MemoryGame entity schema",
 *     @OA\Property(
 *         property="Id",
 *         type="integer",
 *         description="Primary key of the MemoryGame"
 *     ),
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         description="Foreign key referencing GameInstances"
 *     ),
 *     @OA\Property(
 *         property="Mode",
 *         type="string",
 *         description="Mode of the memory game"
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
 *         description="Description of the images",
 *         nullable=true
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
        'GameInstanceId' => 'integer',
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
