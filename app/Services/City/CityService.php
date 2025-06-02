<?php

namespace App\Services\City;

use App\Repositories\City\CityRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CityService
{
    public function __construct(protected CityRepository $cityRepository) {}    
    
    public function fetchToSelect(Request $request): Collection
    {
        // RECUPERANDO O PARÂMETRO
        $term = $request->q;
        
        // VERIFICANDO SE O PARÂMETRO ESTA VAZIO
        if(empty($term)){
            // RETORNANDO UM ARRAY VAZIO
            return collect();
        }
        
        // STRING DE BUSCA
        $filter = '%'.str_replace(' ', '%', $term).'%';
        
        // BUSCANDO AS CIDADES
        $cityCollection = $this->cityRepository->fetchByName($filter);
        
        // RETORNANDO O ARRAY COM A LISTA DE REGISTROS
        return $cityCollection;
    }
}