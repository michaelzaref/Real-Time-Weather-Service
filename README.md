# 🌦️ Laravel Weather API (Open-Meteo)

A clean and flexible Laravel backend that fetches real-time and hourly weather forecast data from the [Open-Meteo API](https://open-meteo.com/en/docs), and returns **chart-ready** output for frontend visualization tools like Chart.js, Highcharts, or ApexCharts.

---

## 🚀 Features

- 🔥 **Real-Time Weather**: Get current temperature, wind speed, and more.
- 📊 **Forecast Data**: Fetch hourly weather data for plotting time-series charts.
- 🧱 **Scalable Structure**: Uses controllers, services, and route separation for clean architecture.
- 🧠 **Flexible Inputs**: Supports custom weather variables like temperature, humidity, wind, etc.
- 🌐 **No API Key Needed**: Open-Meteo is completely free.

---


## 🛠️ Installation

1. **Clone the repository:**

```bash
git clone https://github.com/yourusername/laravel-weather-api.git
cd laravel-weather-api
2. **Install dependencies:
composer install
3. **Set up environment:
cp .env.example .env
php artisan key:generate
4.Run the server:
php artisan serve
🔗 API Endpoints
✅ Current Weather

Fetch real-time weather data.

GET /api/weather/current?lat=30.0444&lon=31.2357
Response:
{
  "temperature": 29.1,
  "windspeed": 5.4,
  "winddirection": 240,
  "weathercode": 1,
  "time": "2025-07-12T14:00"
}
📈 Hourly Forecast (Chart-Ready)
Fetch hourly weather variables like temperature and humidity.

GET /api/weather/chart?lat=30.0444&lon=31.2357&variables[]=temperature_2m&variables[]=relative_humidity_2m
Response:
{
  "temperature_2m": {
    "labels": ["2025-07-12T00:00", "2025-07-12T01:00", ...],
    "data": [27.8, 27.4, ...]
  },
  "relative_humidity_2m": {
    "labels": ["2025-07-12T00:00", ...],
    "data": [58, 60, ...]
  }
}


