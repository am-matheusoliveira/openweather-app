<?php

use Illuminate\Support\Facades\Route;

# Home
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

# Buscar e salvar os Dados da API
Route::post('/fetchWeatherData', [App\Http\Controllers\WeatherController::class, 'fetchWeatherData']);

# View de listagem dos Dados climáticas
Route::get('/weather', [App\Http\Controllers\WeatherController::class, 'weather']);

# Rota que popula os Dados do Plugin Datatables
Route::get('/weatherData', [App\Http\Controllers\WeatherController::class, 'weatherData']);