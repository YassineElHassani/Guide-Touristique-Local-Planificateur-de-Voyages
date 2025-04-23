<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class reservations extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationsFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'event_id',
        'user_id',
        'date',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(events::class);
    }

    // Methods
    public function bookEvent()
    {
        return self::create([
            'event_id' => $this->event_id,
            'user_id' => Auth::id(),
            'date' => $this->date,
            'status' => 'pending',
        ]);
    }

    public function cancelBooking()
    {
        $this->status = 'cancelled';
        return $this->save();
    }
}
