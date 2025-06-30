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

    /**
     * Mutator para convertir el género de texto completo a código
     */
    public function setGenderAttribute($value)
    {
        $genderMap = [
            'Male' => 'M',
            'Female' => 'F',
            'Other' => 'O',
            'Masculino' => 'M',
            'Femenino' => 'F',
            'Otro' => 'O',
            'M' => 'M',
            'F' => 'F',
            'O' => 'O'
        ];

        $this->attributes['Gender'] = $genderMap[$value] ?? $value;
    }

    /**
     * Accessor para convertir el código de género a texto completo
     */
    public function getGenderAttribute($value)
    {
        $genderMap = [
            'M' => 'Male',
            'F' => 'Female',
            'O' => 'Other'
        ];

        return $genderMap[$value] ?? $value;
    }
}
