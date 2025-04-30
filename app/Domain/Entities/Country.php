<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Country",
 *     type="object",
 *     required={"Id", "Name"},
 *     @OA\Property(
 *         property="Id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="Name",
 *         type="string",
 *         example="Peru"
 *     ),
 * )
 */
class Country extends Model
{
    protected $table = "Country";
    protected $primaryKey = "Id";
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
