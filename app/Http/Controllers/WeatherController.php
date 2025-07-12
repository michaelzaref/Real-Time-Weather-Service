<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenMeteoService;

class WeatherController extends Controller
{
    protected $weather;

    public function __construct(OpenMeteoService $weather)
    {
        $this->weather = $weather;
    }

    public function current(Request $request)
    {
        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric'
        ]);

        $data = $this->weather->fetchCurrentWeather($validated['lat'], $validated['lon']);

        return isset($data['error']) ? response()->json($data, 500) : response()->json($data);
    }

    public function forecast(Request $request)
    {
        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric'
        ]);

        $data = $this->weather->fetchForecast($validated['lat'], $validated['lon']);

        return isset($data['error']) ? response()->json($data, 500) : response()->json($data);
    }
}
