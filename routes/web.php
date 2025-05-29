<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WeatherController;

# Home
Route::get('/', [HomeController::class, 'index'])->name('home');

# Buscar e salvar os Dados da API
Route::get('fetchWeatherData', [WeatherController::class, 'fetchWeatherData'])->name('fetchWeatherData');

# Rota que retorna os relatórios das condições climáticas
Route::get('weatherData', [WeatherController::class, 'weatherData'])->name('weatherData');