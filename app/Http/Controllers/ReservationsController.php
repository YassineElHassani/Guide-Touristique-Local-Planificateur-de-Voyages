<?php

namespace App\Http\Controllers;

use App\Models\reservations;
use App\Models\events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the user's reservations.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your reservations.');
        }
        
        $reservations = reservations::where('user_id', Auth::id())->get();
        return view('client.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create($eventId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to book events.');
        }
        
        $event = events::findOrFail($eventId);
        return view('client.reservations.create', compact('event'));
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request, $eventId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to book events.');
        }
        
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);
        
        reservations::create([
            'event_id' => $eventId,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'status' => 'pending',
        ]);
        
        return redirect()->route('client.reservations.index')
            ->with('success', 'Event booked successfully.');
    }

    /**
     * Display the specified reservation.
     */
    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your reservations.');
        }
        
        $reservation = reservations::findOrFail($id);
        
        // Check if the reservation belongs to the authenticated user or if user is admin/guide
        if ($reservation->user_id !== Auth::id() && Auth::user()->role !== 'admin' && Auth::user()->role !== 'guide') {
            return redirect()->route('client.reservations.index')
                ->with('error', 'You are not authorized to view this reservation.');
        }
        
        return view('client.reservations.show', compact('reservation'));
    }

    /**
     * Cancel a reservation.
     */
    public function cancel($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to manage your reservations.');
        }
        
        $reservation = reservations::findOrFail($id);
        
        // Check if the reservation belongs to the authenticated user
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->route('client.reservations.index')
                ->with('error', 'You are not authorized to cancel this reservation.');
        }
        
        $reservation->update(['status' => 'cancelled']);
        
        return redirect()->route('client.reservations.index')
            ->with('success', 'Reservation cancelled successfully.');
    }

    /**
     * Display a listing of all reservations for admin/guide.
     */
    public function adminIndex()
    {
        $reservations = reservations::all();
        return view('admin.reservations', compact('reservations'));
    }

    /**
     * Update reservation status (for admin/guide).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);
        
        $reservation = reservations::findOrFail($id);
        $reservation->update(['status' => $request->status]);
        
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservation status updated successfully.');
        } else {
            return redirect()->route('guide.reservations.index')
                ->with('success', 'Reservation status updated successfully.');
        }
    }
}