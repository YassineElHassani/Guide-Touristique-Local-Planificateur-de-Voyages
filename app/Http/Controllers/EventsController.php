<?php

namespace App\Http\Controllers;

use App\Models\events;
use App\Models\destinations;
use App\Models\reviews;
use App\Models\reservations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{
    // Public routes
    public function index()
    {
        $events = events::all();
        return view('events.index', compact('events'));
    }

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

    // Admin methods
    public function adminShow($id)
    {
        try {
            $event = events::findOrFail($id);
            $reviews = reviews::where('event_id', $id)->get();
            return view('admin.events.show', compact('event', 'reviews'));
        } catch (\Exception $e) {
            Log::error('Error showing event: ' . $e->getMessage());
            return redirect()->route('admin.events.index')
                ->with('error', 'Error showing event: ' . $e->getMessage());
        }
    }
    
    public function adminIndex()
    {
        try {
            $events = events::all();
            return view('admin.events.index', compact('events'));
        } catch (\Exception $e) {
            Log::error('Error loading events: ' . $e->getMessage());
            return redirect()->route('admin.dashboard.index')
                ->with('error', 'Error loading events: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $destinations = destinations::all();
            return view('admin.events.create', compact('destinations'));
        } catch (\Exception $e) {
            Log::error('Error loading destinations: ' . $e->getMessage());
            return redirect()->route('admin.events.index')
                ->with('error', 'Error loading destinations: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'date' => 'required|date',
                'location' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = [
                'name' => $request->name,
                'date' => $request->date,
                'location' => $request->location,
                'description' => $request->description,
                'price' => $request->price,
            ];

            // Handle image upload if present
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('events', 'public');
                $data['image'] = $imagePath;
            }

            events::create($data);

            return redirect()->route('admin.events.index')
                ->with('success', 'Event created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating event: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating event: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $event = events::findOrFail($id);
            $destinations = destinations::all();
            return view('admin.events.edit', compact('event', 'destinations'));
        } catch (\Exception $e) {
            Log::error('Error loading event for edit: ' . $e->getMessage());
            return redirect()->route('admin.events.index')
                ->with('error', 'Error loading event for edit: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'date' => 'required|date',
                'location' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $event = events::findOrFail($id);
            
            $data = [
                'name' => $request->name,
                'date' => $request->date,
                'location' => $request->location,
                'description' => $request->description,
                'price' => $request->price,
            ];

            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                }
                $imagePath = $request->file('image')->store('events', 'public');
                $data['image'] = $imagePath;
            }

            $event->update($data);

            return redirect()->route('admin.events.index')
                ->with('success', 'Event updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating event: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating event: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $event = events::findOrFail($id);
            
            // Check if there are any reservations before deleting
            $reservationsCount = reservations::where('event_id', $id)->count();
            
            if ($reservationsCount > 0) {
                return redirect()->route('admin.events.index')
                    ->with('error', 'Cannot delete event with existing reservations. Cancel all reservations first.');
            }
            
            // Delete image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            
            $event->delete();

            return redirect()->route('admin.events.index')
                ->with('success', 'Event deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting event: ' . $e->getMessage());
            return redirect()->route('admin.events.index')
                ->with('error', 'Error deleting event: ' . $e->getMessage());
        }
    }
}