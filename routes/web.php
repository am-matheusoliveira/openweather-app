<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WeatherController;

# Home
Route::get('/', [HomeController::class, 'index'])->name('home');

# Buscar e salvar os Dados da API
Route::post('fetchWeatherData', [WeatherController::class, 'fetchWeatherData'])->name('fetchWeatherData');

# View de listagem dos Dados climáticas
Route::get('/weather', [WeatherController::class, 'weather'])->name('weather');

# Rota que popula os Dados do Plugin Datatables
Route::get('weatherData', [WeatherController::class, 'weatherData'])->name('weatherData');