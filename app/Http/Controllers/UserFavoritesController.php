<?php

namespace App\Http\Controllers;

use App\Models\user_favorites;
use App\Http\Requests\Storeuser_favoritesRequest;
use App\Http\Requests\Updateuser_favoritesRequest;

class UserFavoritesController extends Controller
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
    public function store(Storeuser_favoritesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(user_favorites $user_favorites)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user_favorites $user_favorites)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateuser_favoritesRequest $request, user_favorites $user_favorites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user_favorites $user_favorites)
    {
        //
    }
}
