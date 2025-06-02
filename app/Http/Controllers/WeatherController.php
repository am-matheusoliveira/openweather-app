<?php

namespace App\Http\Controllers;

use App\Http\Requests\FetchWeatherDataRequest;
use App\Services\Weather\WeatherService;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    public function __construct(protected WeatherService $weatherService) {}
    
    public function fetchCurrent(FetchWeatherDataRequest $request): JsonResponse
    {
        $result = $this->weatherService->fetchAndStoreCurrentWeather($request->validated());
        
        if (isset($result->error)) {
            return response()->json(['message' => $result->message], $result->status);
        }
        
        return response()->json($result->toArray(), 200);
    }
    
    public function fetchReports(): JsonResponse
    {
        $data = $this->weatherService->getReports();
        return response()->json($data, 200);
    }
}