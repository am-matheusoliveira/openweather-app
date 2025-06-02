<?php

namespace App\Helpers;

class WeatherErrorMapper
{
    public static function getMessage(int $status): string
    {
        return [
            404 => 'Cidade informada não foi encontrada.',
            401 => 'Chave de API inválida. Consulte https://openweathermap.org/faq#error401 para mais informações.'
        ][$status] ?? 'Ocorreu um erro inesperado ao buscar os dados meteorológicos.';
    }
}