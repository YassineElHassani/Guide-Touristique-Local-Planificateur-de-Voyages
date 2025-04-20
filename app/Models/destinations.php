<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class destinations extends Model
{
    /** @use HasFactory<\Database\Factories\DestinationsFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'address',
        'category',
        'coordinates',
    ];

    // Relationships
    public function reviews()
    {
        return $this->hasMany(reviews::class);
    }

    public function itineraries()
    {
        return $this->belongsToMany(itineraries::class, 'itinerary_destination')
            ->withPivot('day', 'order')
            ->withTimestamps();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'user_favorites');
    }

    // Methods
    public function getDetails()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'category' => $this->category,
            'coordinates' => $this->coordinates,
            'reviews' => $this->reviews,
        ];
    }

    public function getCategory()
    {
        return categories::where('name', $this->category)->first();
    }
}
