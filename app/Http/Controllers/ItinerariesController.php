<?php

namespace App\Http\Controllers;

use App\Models\itineraries;
use App\Http\Requests\StoreitinerariesRequest;
use App\Http\Requests\UpdateitinerariesRequest;

class ItinerariesController extends Controller
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
    public function store(StoreitinerariesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(itineraries $itineraries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(itineraries $itineraries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateitinerariesRequest $request, itineraries $itineraries)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(itineraries $itineraries)
    {
        //
    }
}
