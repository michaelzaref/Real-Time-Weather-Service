<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenMeteoService;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    protected $weather;

    public function __construct(OpenMeteoService $weather)
    {
        $this->weather = $weather;
    }

    public function current(Request $request)
    {
        try {
            $validated = $request->validate([
                'lat' => 'required|numeric',
                'lon' => 'required|numeric'
            ]);

            $data = $this->weather->fetchCurrentWeather($validated['lat'], $validated['lon']);

            if (isset($data['error'])) {
                Log::error('Current Weather Error', $data);
                return response()->json($data, 500);
            }

            return response()->json($data);
        } catch (\Throwable $e) {
            Log::error('Exception in current weather', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function forecast(Request $request)
    {
        try {
            $validated = $request->validate([
                'lat' => 'required|numeric',
                'lon' => 'required|numeric'
            ]);

            $data = $this->weather->fetchForecast($validated['lat'], $validated['lon']);

            if (isset($data['error'])) {
                Log::error('Forecast Error', $data);
                return response()->json($data, 500);
            }

            return response()->json($data);
        } catch (\Throwable $e) {
            Log::error('Exception in forecast', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
