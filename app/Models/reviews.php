<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewsFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'destination_id',
        'event_id',
        'comment',
        'rating',
    ];

    protected $casts = [
        'rating' => 'float',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function destination()
    {
        return $this->belongsTo(destinations::class);
    }

    public function event()
    {
        return $this->belongsTo(events::class);
    }

    // Methods
    public function addReview($data)
    {
        return self::create([
            'user_id' => Auth::id(),
            'destination_id' => $data['destination_id'] ?? null,
            'event_id' => $data['event_id'] ?? null,
            'comment' => $data['comment'],
            'rating' => $data['rating'],
        ]);
    }

    public function readReviews()
    {
        if ($this->destination_id) {
            return reviews::where('destination_id', $this->destination_id)->get();
        } elseif ($this->event_id) {
            return reviews::where('event_id', $this->event_id)->get();
        }
        
        return null;
    }
}
