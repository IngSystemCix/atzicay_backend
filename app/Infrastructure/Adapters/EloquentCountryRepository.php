<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\Country;
use App\Domain\Repositories\CountryRepository;

class EloquentCountryRepository implements CountryRepository
{
    public function createCountry(array $data): Country {
        return Country::create($data);
    }
    
    public function getAllCountries(): array {
        return array_map(function (Country $country) {
            return $country->toArray();
        }, Country::all()->toArray());
    }
    
    public function getCountryById(int $id): Country {
        return Country::find($id);
    }
}