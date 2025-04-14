<?php

namespace App\Http\Controllers;

use App\Models\weather_forecasts;
use App\Http\Requests\Storeweather_forecastsRequest;
use App\Http\Requests\Updateweather_forecastsRequest;

class WeatherForecastsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storeweather_forecastsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(weather_forecasts $weather_forecasts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(weather_forecasts $weather_forecasts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateweather_forecastsRequest $request, weather_forecasts $weather_forecasts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(weather_forecasts $weather_forecasts)
    {
        //
    }
}
