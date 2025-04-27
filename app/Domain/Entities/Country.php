<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Country",
 *     type="object",
 *     required={"id", "name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Peru"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2025-04-26T12:34:56Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2025-04-26T12:34:56Z"
 *     )
 * )
 */
class Country extends Model
{
    protected $table = "Country";
    protected $primarykey = "Id";
    public $timestamps = false;

    protected $fillable = [
        'Name',
    ];

    protected $casts = [
        'Name' => 'string',
    ];

    /**
     * Relationship with the User entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function countries()
    {
        return $this->hasOne(User::class, 'Country', 'Id');
    }
}
