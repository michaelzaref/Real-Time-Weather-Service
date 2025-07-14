<?php

return [
    'api_url' => env('WEATHER_API_URL', 'https://api.open-meteo.com/v1/forecast'),
    'cache_minutes' => env('WEATHER_CACHE_MINUTES', 10),
];
