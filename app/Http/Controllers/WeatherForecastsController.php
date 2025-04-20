<?php

namespace App\Http\Controllers;

use App\Models\weather_forecasts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherForecastsController extends Controller
{
    /**
     * Get weather forecast for a location.
     */
    public function getWeather(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
        ]);
        
        $location = $request->location;
        $today = now()->format('Y-m-d');
        
        // Check if we already have weather data for this location and day
        $forecast = weather_forecasts::where('location', $location)
            ->where('date', $today)
            ->first();
        
        // If we don't have data or it's more than 3 hours old, fetch new data
        if (!$forecast || now()->diffInHours($forecast->updated_at) > 3) {
            try {
                // This would use OpenWeatherMap API or similar
                // You'll need to sign up for an API key from a weather service provider
                $apiKey = config('services.openweather.key');
                $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                    'q' => $location,
                    'appid' => $apiKey,
                    'units' => 'metric',
                ]);
                
                if ($response->successful()) {
                    $weatherData = $response->json();
                    
                    // Create or update the forecast
                    $forecast = weather_forecasts::updateOrCreate(
                        ['location' => $location, 'date' => $today],
                        [
                            'temperature' => $weatherData['main']['temp'],
                            'conditions' => $weatherData['weather'][0]['main'],
                        ]
                    );
                } else {
                    // If API request failed and we don't have cached data
                    if (!$forecast) {
                        return response()->json(['error' => 'Could not fetch weather data'], 404);
                    }
                    // If we have old data, we'll just use that
                }
            } catch (\Exception $e) {
                // If there's an exception and we don't have cached data
                if (!$forecast) {
                    return response()->json(['error' => 'Could not fetch weather data: ' . $e->getMessage()], 500);
                }
                // If we have old data, we'll just use that
            }
        }
        
        return response()->json($forecast);
    }
    
    /**
     * Widget for displaying weather forecast.
     */
    public function widget($location)
    {
        $today = now()->format('Y-m-d');
        
        // Try to get cached forecast
        $forecast = weather_forecasts::where('location', $location)
            ->where('date', $today)
            ->first();
        
        // If no forecast exists, return empty widget
        if (!$forecast) {
            return view('widgets.weather', ['forecast' => null, 'location' => $location]);
        }
        
        return view('widgets.weather', ['forecast' => $forecast, 'location' => $location]);
    }
}