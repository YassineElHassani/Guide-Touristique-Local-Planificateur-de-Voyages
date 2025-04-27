<?php

namespace App\Http\Controllers;

use App\Models\reservations;
use App\Models\events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationsController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your reservations.');
        }
        
        $reservations = reservations::where('user_id', Auth::id())->get();
        return view('client.reservations.index', compact('reservations'));
    }

    public function create($eventId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to book events.');
        }
        
        $event = events::findOrFail($eventId);
        return view('client.reservations.create', compact('event'));
    }

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

    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your reservations.');
        }
        
        $reservation = reservations::findOrFail($id);
        
        if ($reservation->user_id !== Auth::id() && Auth::user()->role !== 'admin' && Auth::user()->role !== 'guide') {
            return redirect()->route('client.reservations.index')
                ->with('error', 'You are not authorized to view this reservation.');
        }
        if (Auth::user()->role === 'admin') {
            return view('admin.reservations.show', compact('reservation'));
        } elseif (Auth::user()->role === 'guide') {
            return view('guide.reservations.show', compact('reservation'));
        } elseif (Auth::user()->role === 'client') {
            return view('client.reservations.show', compact('reservation'));
        }
    }

    public function adminIndex()
    {
        $reservations = reservations::with(['user', 'event'])
        ->orderBy('created_at', 'desc')
        ->paginate(15);
        
        return view('admin.reservations.index', compact('reservations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'admin_notes' => 'nullable|string',
        ]);
        
        $reservation = reservations::findOrFail($id);
        $reservation->update([
            'status' => $request->status
        ]);
        
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservation status updated successfully.');
        } else {
            return redirect()->route('guide.reservations.index')
                ->with('success', 'Reservation status updated successfully.');
        }
    }

    public function destroy($id)
    {
        try {
            $reservation = reservations::findOrFail($id);
            $reservation->delete();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.reservations.index')
                    ->with('success', 'Reservation has been deleted successfully.');
            } else {
                return redirect()->route('guide.reservations.index')
                    ->with('success', 'Reservation has been deleted successfully.');
            }
            
        } catch (\Exception $e) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.reservations.index')
                    ->with('error', 'Error deleting reservation: ' . $e->getMessage());
            } else {
                return redirect()->route('guide.reservations.index')
                    ->with('error', 'Error deleting reservation: ' . $e->getMessage());
            }
        }
    }
}