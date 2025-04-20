<?php

namespace App\Http\Controllers;

use App\Models\events;
use App\Models\reviews;
use App\Models\reservations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{
    /**
     * Display a listing of all events.
     */
    public function index()
    {
        $events = events::all();
        return view('events.index', compact('events'));
    }

    /**
     * Display the specified event.
     */
    public function show($id)
    {
        $event = events::findOrFail($id);
        $reviews = reviews::where('event_id', $id)->get();
        
        // Check if user has a reservation for this event
        $hasReservation = false;
        if (Auth::check()) {
            $hasReservation = reservations::where('user_id', Auth::id())
                ->where('event_id', $id)
                ->exists();
        }
        
        return view('events.show', compact('event', 'reviews', 'hasReservation'));
    }

    /**
     * Search for events.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $dateFilter = $request->input('date');
        
        $events = events::query();
        
        if (!empty($query)) {
            $events->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('location', 'like', '%' . $query . '%');
            });
        }
        
        if (!empty($dateFilter)) {
            $events->whereDate('date', '=', $dateFilter);
        }
        
        $events = $events->get();
        
        return view('events.search_results', compact('events', 'query', 'dateFilter'));
    }

    /**
     * Get upcoming events (for homepage).
     */
    public function upcoming()
    {
        $now = now();
        $upcomingEvents = events::where('date', '>=', $now)
            ->orderBy('date', 'asc')
            ->take(4)
            ->get();
            
        return view('events.upcoming', compact('upcomingEvents'));
    }

    /**
     * Book an event.
     */
    public function book(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to book events.');
        }
        
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);
        
        reservations::create([
            'event_id' => $id,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'status' => 'pending',
        ]);
        
        return redirect()->route('client.reservations')
            ->with('success', 'Event booked successfully.');
    }

    // Guide & Admin methods below - protected by middleware in routes

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('guide.events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'image' => 'nullable|image|max:2048',
            'location' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        events::create([
            'name' => $request->name,
            'date' => $request->date,
            'image' => $imagePath,
            'location' => $request->location,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // Redirect based on user role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
        } else {
            return redirect()->route('guide.events.index')->with('success', 'Event created successfully.');
        }
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit($id)
    {
        $event = events::findOrFail($id);
        
        // Determine the appropriate view based on user role
        if (Auth::user()->role === 'admin') {
            return view('admin.events.edit', compact('event'));
        } else {
            return view('guide.events.edit', compact('event'));
        }
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'image' => 'nullable|image|max:2048',
            'location' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $event = events::findOrFail($id);
        
        $imagePath = $event->image;
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $imagePath = $request->file('image')->store('events', 'public');
        }

        $event->update([
            'name' => $request->name,
            'date' => $request->date,
            'image' => $imagePath,
            'location' => $request->location,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // Redirect based on user role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
        } else {
            return redirect()->route('guide.events.index')->with('success', 'Event updated successfully.');
        }
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy($id)
    {
        $event = events::findOrFail($id);
        
        // Delete image if it exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        
        $event->delete();

        // Redirect based on user role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
        } else {
            return redirect()->route('guide.events.index')->with('success', 'Event deleted successfully.');
        }
    }

    /**
     * Admin index - show all events for management.
     */
    public function adminIndex()
    {
        $events = events::all();
        return view('admin.events', compact('events'));
    }

    /**
     * Guide index - show only events for this guide.
     */
    public function guideIndex()
    {
        $events = events::all(); // In a real app, filter by guide ID
        return view('guide.events.index', compact('events'));
    }
}