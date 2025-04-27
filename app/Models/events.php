<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class events extends Model
{
    /** @use HasFactory<\Database\Factories\EventsFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'date',
        'image',
        'location',
        'description',
        'price',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'float',
    ];

    // Relationships
    public function reviews()
    {
        return $this->hasMany(reviews::class, 'event_id');
    }

    public function reservations()
    {
        return $this->hasMany(reservations::class, 'event_id');
    }

    public function category()
    {
        return $this->belongsTo(categories::class);
    }

    // Methods
    public function getDetails()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date' => $this->date,
            'image' => $this->image,
            'location' => $this->location,
            'description' => $this->description,
            'price' => $this->price,
            'reviews' => $this->reviews,
        ];
    }

    public function createEvent()
    {
        return self::create([
            'name' => $this->name,
            'date' => $this->date,
            'image' => $this->image,
            'location' => $this->location,
            'description' => $this->description,
            'price' => $this->price,
        ]);
    }

    public function deleteEvent()
    {
        return $this->delete();
    }
}