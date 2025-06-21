<?php

namespace App\Services;

use App\Models\Country;

class CountryService
{
    public function getAllCountries()
    {
        return Country::select('Id', 'Name')
            ->orderBy('Name', 'asc')
            ->get();
    }

}