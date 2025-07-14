<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class WeatherControllerErrorHandlingTest extends TestCase
{
    public function test_current_weather_controller_exception()
{
    $mock = \Mockery::mock(\App\Services\OpenMeteoService::class);
    $mock->shouldReceive('fetchCurrentWeather')
         ->andThrow(new \Exception('Simulated failure'));

    $this->app->instance(\App\Services\OpenMeteoService::class, $mock);

    $response = $this->getJson('/api/weather/current?lat=30.0444&lon=31.2357');

    $response->assertStatus(500)
             ->assertJsonFragment(['error' => 'Internal Server Error']);
}
    
public function test_forecast_weather_controller_exception()
{
    $mock = \Mockery::mock(\App\Services\OpenMeteoService::class);
    $mock->shouldReceive('fetchForecast')
         ->andThrow(new \Exception('Simulated forecast exception'));

    $this->app->instance(\App\Services\OpenMeteoService::class, $mock);

    $response = $this->getJson('/api/weather/forecast?lat=30.0444&lon=31.2357');

    $response->assertStatus(500)
             ->assertJsonFragment(['error' => 'Internal Server Error']);
}



}
