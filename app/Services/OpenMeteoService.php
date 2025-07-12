<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenMeteoService
{
    protected $base = 'https://api.open-meteo.com/v1/forecast';

    public function fetchCurrentWeather(float $lat, float $lon): array
    {
        $query = [
            'latitude' => $lat,
            'longitude' => $lon,
            'timezone' => 'auto',
            'current_weather' => true
        ];

        $response = Http::get($this->base, $query);

        return $response->successful() ? $response->json()['current_weather'] ?? [] : ['error' => 'Failed to fetch current weather'];
    }

    public function fetchForecast(float $lat, float $lon, array $variables = ['temperature_2m', 'relative_humidity_2m']): array
    {
        $query = [
            'latitude' => $lat,
            'longitude' => $lon,
            'timezone' => 'auto',
            'hourly' => implode(',', $variables)
        ];

        $response = Http::get($this->base, $query);

        return $response->successful() ? $response->json()['hourly'] ?? [] : ['error' => 'Failed to fetch forecast'];
    }
}
