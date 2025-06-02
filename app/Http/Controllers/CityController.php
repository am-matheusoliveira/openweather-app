<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\City\CityService;

class CityController extends Controller
{
    public function __construct(protected CityService $cityService) {}

    public function fetchCities(Request $request)
    {
        $data = $this->cityService->fetchToSelect($request);
        return response()->json($data, 200);
    }
}
