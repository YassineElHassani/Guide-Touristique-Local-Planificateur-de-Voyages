<?php

namespace App\Http\Controllers;

use App\Models\profiles;
use App\Http\Requests\StoreprofilesRequest;
use App\Http\Requests\UpdateprofilesRequest;

class ProfilesController extends Controller
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
    public function store(StoreprofilesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(profiles $profiles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(profiles $profiles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprofilesRequest $request, profiles $profiles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(profiles $profiles)
    {
        //
    }
}
