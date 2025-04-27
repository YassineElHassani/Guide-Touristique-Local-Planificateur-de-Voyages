<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weather_forecasts extends Model
{
    /** @use HasFactory<\Database\Factories\WeatherForecastsFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'location',
        'date',
        'temperature',
        'conditions',
    ];

    protected $casts = [
        'date' => 'date',
        'temperature' => 'float',
    ];

    public function fetchForecast($location, $date)
    {
        return self::where('location', $location)
            ->where('date', $date)
            ->first();
    }
}
