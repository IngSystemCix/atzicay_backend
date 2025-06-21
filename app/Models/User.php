<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $fillable = [
        'Activate',
        'Email',
        'Name',
        'LastName',
        'Gender',
        'CountryId',
        'City',
        'Birthdate',
        'CreatedAt',
    ];

    public function countryId(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'CountryId');
    }

    protected function casts(): array
    {
        return [
            'Activate' => 'boolean',
            'CreatedAt' => 'timestamp',
        ];
    }
}
