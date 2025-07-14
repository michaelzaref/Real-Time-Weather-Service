<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeatherApiTest extends TestCase
{
    public function test_weather_forecast_returns_time_series_structure()
    {
        $response = $this->getJson('/api/weather/forecast?lat=30.0444&lon=31.2357&variables[]=temperature_2m&variables[]=relative_humidity_2m');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'time',
            'temperature_2m',
            'relative_humidity_2m',
        ]);


        $json = $response->json();
        $this->assertIsArray($json['time']);
        $this->assertIsArray($json['temperature_2m']);
        $this->assertIsArray($json['relative_humidity_2m']);
    }
    public function test_current_weather_real_api_response()
    {
        $response = $this->getJson('/api/weather/current?lat=30.0444&lon=31.2357');

        $response->assertOk()
                ->assertJsonStructure([
                    'time',
                    'interval',
                    'temperature',
                    'windspeed',
                    'winddirection',
                    'is_day',
                    'weathercode'
                ]);
    }
    
}
