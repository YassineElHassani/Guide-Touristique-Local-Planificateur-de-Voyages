<?php

namespace App\Http\Controllers;

use App\Models\weather_forecasts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherForecastsController extends Controller
{
    public function getWeather(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
        ]);
        
        $location = $request->location;
        $today = now()->format('Y-m-d');
        
        $forecast = weather_forecasts::where('location', $location)
            ->where('date', $today)
            ->first();
        
        if (!$forecast || now()->diffInHours($forecast->updated_at) > 3) {
            try {
                $apiKey = config('services.openweather.key');
                $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                    'q' => $location,
                    'appid' => $apiKey,
                    'units' => 'metric',
                ]);
                
                if ($response->successful()) {
                    $weatherData = $response->json();
                    
                    $forecast = weather_forecasts::updateOrCreate(
                        ['location' => $location, 'date' => $today],
                        [
                            'temperature' => $weatherData['main']['temp'],
                            'conditions' => $weatherData['weather'][0]['main'],
                        ]
                    );
                } else {
                    if (!$forecast) {
                        return response()->json(['error' => 'Could not fetch weather data'], 404);
                    }
                }
            } catch (\Exception $e) {
                if (!$forecast) {
                    return response()->json(['error' => 'Could not fetch weather data: ' . $e->getMessage()], 500);
                }
            }
        }
        
        return response()->json($forecast);
    }
    
    public function widget($location)
    {
        $today = now()->format('Y-m-d');
        
        $forecast = weather_forecasts::where('location', $location)
            ->where('date', $today)
            ->first();
        
        if (!$forecast) {
            return view('widgets.weather', ['forecast' => null, 'location' => $location]);
        }
        
        return view('widgets.weather', ['forecast' => $forecast, 'location' => $location]);
    }
}