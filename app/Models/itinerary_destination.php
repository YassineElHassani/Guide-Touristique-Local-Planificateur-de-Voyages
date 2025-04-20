<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itinerary_destination extends Model
{
    /** @use HasFactory<\Database\Factories\ItineraryDestinationFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'itinerary_id',
        'destination_id',
        'day',
        'order',
    ];
}
