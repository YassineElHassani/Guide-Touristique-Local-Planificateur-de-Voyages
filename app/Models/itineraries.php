<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class itineraries extends Model
{
    /** @use HasFactory<\Database\Factories\ItinerariesFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function destinations()
    {
        return $this->belongsToMany(destinations::class, 'itinerary_destination')
            ->withPivot('day', 'order')
            ->withTimestamps();
    }

    // Methods
    public function createPlan()
    {
        return self::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
    }

    public function updatePlan()
    {
        return $this->update([
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
    }

    public function deletePlan()
    {
        return $this->delete();
    }
}
