<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

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
