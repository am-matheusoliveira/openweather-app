<?php

namespace App\Services\Weather;

use App\Helpers\WeatherConditionTranslator;
use App\Helpers\WeatherErrorMapper;
use App\Repositories\Weather\WeatherRepository;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function __construct(protected WeatherRepository $weatherRepository) {}
    
    public function fetchAndStoreCurrentWeather(array $params)
    {
        $apiKey = config('app.OPENWEATHERMAP_API_KEY');
        
        $query = [
            'appid' => $apiKey,
            'units' => 'metric',
            'lang'  => 'pt_br',
        ];
        
        if (isset($params['select-cidade'])) {
            $query['id'] = $params['select-cidade'];
        } else {
            $query['q'] = $params['other-city'] . ', BR';
        }
        
        $response = Http::get('http://api.openweathermap.org/data/2.5/weather', $query);
        
        if ($response->failed()) {
            return (object) [
                'error' => true,
                'status' => $response->status(),
                'message' => WeatherErrorMapper::getMessage($response->status())
            ];
        }
        
        $data = $response->json();
        $translated = WeatherConditionTranslator::translate($data['weather'][0]['main']);
        
        return $this->weatherRepository->storeWeatherData($data, $translated);
    }

    public function getReports(): array
    {
        return $this->weatherRepository->getStoredWeatherReports();
    }
}