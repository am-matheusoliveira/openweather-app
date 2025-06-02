<?php

namespace App\Helpers;

class WeatherConditionTranslator
{
    public static function translate(string $condition): string
    {
        return [
            'Clear'        => 'Céu limpo',
            'Clouds'       => 'Nuvens',
            'Rain'         => 'Chuva',
            'Snow'         => 'Neve',
            'Drizzle'      => 'Garoa',
            'Thunderstorm' => 'Trovoada',
            'Mist'         => 'Névoa',
            'Smoke'        => 'Fumaça',
            'Haze'         => 'Neblina',
            'Dust'         => 'Poeira',
            'Fog'          => 'Nevoeiro',
            'Sand'         => 'Areia',
            'Ash'          => 'Cinzas',
            'Squall'       => 'Tempestade',
            'Tornado'      => 'Tornado',
        ][$condition] ?? $condition;
    }
}