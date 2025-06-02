<?php

namespace App\Repositories\Weather;

use Carbon\Carbon;
use App\DTOs\Weather\CurrentWeatherDTO;
use App\Models\{City, Wind, Cloud, WeatherReport, WeatherCondition};

class WeatherRepository
{
    public function storeWeatherData(array $data, string $mainTranslated): CurrentWeatherDTO
    {
        $city = City::updateOrCreate(
            ['id' => $data['id']],
            [
                'name'      => $data['name'],
                'country'   => $data['sys']['country'],
                'longitude' => $data['coord']['lon'],
                'latitude'  => $data['coord']['lat'],
            ]
        );
        
        $report = WeatherReport::create([
            'city_id'     => $city->id,
            'timezone'    => $data['timezone'],
            'temperature' => $data['main']['temp'],
            'feels_like'  => $data['main']['feels_like'],
            'temp_min'    => $data['main']['temp_min'],
            'temp_max'    => $data['main']['temp_max'],
            'pressure'    => $data['main']['pressure'],
            'humidity'    => $data['main']['humidity'],
            'visibility'  => $data['visibility'],
            'timestamp'   => date('Y-m-d H:i:s', ($data['dt'] + $data['timezone'])),
            'sunrise'     => date('Y-m-d H:i:s', ($data['sys']['sunrise'] + $data['timezone'])),
            'sunset'      => date('Y-m-d H:i:s', ($data['sys']['sunset']  + $data['timezone'])),
        ]);
        
        WeatherCondition::create([
            'report_id'    => $report->id,
            'condition_id' => $data['weather'][0]['id'],
            'main'         => $mainTranslated,
            'description'  => $data['weather'][0]['description'],
            'icon'         => $data['weather'][0]['icon']
        ]);
        
        Wind::create([
            'report_id' => $report->id,
            'speed'     => $data['wind']['speed'],
            'direction' => $data['wind']['deg']
        ]);
        
        Cloud::create([
            'report_id'  => $report->id,
            'cloudiness' => $data['clouds']['all']
        ]);
        
        return new CurrentWeatherDTO(
            $data['name'],
            $data['sys']['country'],
            number_format($data['main']['temp'], 2) . ' °C',
            number_format($data['main']['feels_like'], 2) . ' °C',
            number_format($data['main']['temp_min'], 2) . ' °C',
            number_format($data['main']['temp_max'], 2) . ' °C',
            $data['main']['humidity'] . ' %',
            Carbon::createFromTimestamp($data['dt'] + $data['timezone'])->translatedFormat('d \d\e F \d\e Y, H:i'),
            number_format($data['wind']['speed'], 2) . ' m/s',
            ucfirst($data['weather'][0]['description']),
            $data['weather'][0]['icon']
        );
    }
    
    public function getStoredWeatherReports(): array
    {
        return WeatherReport::with(['city', 'wind', 'cloud', 'conditions'])
            ->get()
            ->sortByDesc('timestamp')
            ->flatMap(function ($report) {
                return $report->conditions->map(function ($condition) use ($report) {
                    return [
                        'nome_cidade'        => $report->city->name,
                        'pais'               => $report->city->country,
                        'temperatura'        => $report->temperature . ' °C',
                        'sensacao_termica'   => $report->feels_like . ' °C',
                        'temp_minima'        => $report->temp_min . ' °C',
                        'temp_maxima'        => $report->temp_max . ' °C',
                        'umidade'            => $report->humidity . ' %',
                        'timestamp'          => Carbon::parse($report->timestamp)->translatedFormat('d \d\e F \d\e Y, H:i'),
                        'velocidade_vento'   => optional($report->wind)->speed . ' m/s',
                        'descricao_condicao' => ucfirst($condition->description),
                        'icon_code_condicao' => $condition->icon
                    ];
                });
            })
            ->values()
            ->toArray();
    }
}