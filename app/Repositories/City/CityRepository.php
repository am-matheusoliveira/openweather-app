<?php

namespace App\Repositories\City;

use App\Models\City;
use App\DTOs\City\CityDTO;
use Illuminate\Support\Collection;

class CityRepository
{
    public function fetchByName(string $filter): Collection
    {
        $cities = City::where('name', 'LIKE', $filter)
            ->where('country', 'BR')
            ->select('id', 'name', 'country')
            ->limit(50)
            ->get();
        
        $cityCollection = $cities->map(function($city){
            return (new CityDTO(
                $city->id,
                $city->name,
                $city->country
            ))->toArray();
        });
        
        return $cityCollection;
    }
}