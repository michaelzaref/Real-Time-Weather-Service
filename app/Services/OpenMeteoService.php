<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OpenMeteoService
{
    protected $base;

    public function __construct()
    {
        $this->base = config('weather.api_url');
    }

    public function fetchCurrentWeather(float $lat, float $lon): array
    {
        $cacheKey = "current_weather_{$lat}_{$lon}";
        return Cache::remember($cacheKey, now()->addMinutes(config('weather.cache_minutes')), function () use ($lat, $lon) {
            try {
                $query = [
                    'latitude' => $lat,
                    'longitude' => $lon,
                    'timezone' => 'auto',
                    'current_weather' => true
                ];

                $response = Http::timeout(10)->get($this->base, $query);

                if ($response->successful()) {
                    return $response->json()['current_weather'] ?? [];
                }

                Log::error('Failed to fetch current weather', ['response' => $response->body()]);
                return ['error' => 'Failed to fetch current weather'];
            } catch (\Throwable $e) {
                Log::error('Exception in fetchCurrentWeather', ['message' => $e->getMessage()]);
                return ['error' => 'Exception occurred'];
            }
        });
    }

    public function fetchForecast(float $lat, float $lon, array $variables = ['temperature_2m', 'relative_humidity_2m']): array
    {
        $cacheKey = "forecast_weather_{$lat}_{$lon}_" . implode('_', $variables);
        return Cache::remember($cacheKey, now()->addMinutes(config('weather.cache_minutes')), function () use ($lat, $lon, $variables) {
            try {
                $query = [
                    'latitude' => $lat,
                    'longitude' => $lon,
                    'timezone' => 'auto',
                    'hourly' => implode(',', $variables)
                ];

                $response = Http::timeout(10)->get($this->base, $query);

                if ($response->successful()) {
                    return $response->json()['hourly'] ?? [];
                }

                Log::error('Failed to fetch forecast', ['response' => $response->body()]);
                return ['error' => 'Failed to fetch forecast'];
            } catch (\Throwable $e) {
                Log::error('Exception in fetchForecast', ['message' => $e->getMessage()]);
                return ['error' => 'Exception occurred'];
            }
        });
    }
}
