<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CityController;

# Home
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('/api')->group(function(){
    # Buscar e salvar os Dados da API
    Route::get('/fetch/weather/current', [WeatherController::class, 'fetchCurrent']);
    
    # Rota que retorna os relatórios das condições climáticas
    Route::get('/fetch/weather/reports', [WeatherController::class, 'fetchReports']);
    
    # Rota para buscar as cidades de forma dinamica e popular o select2
    Route::get('/fetch/cities', [CityController::class, 'fetchCities']);
});