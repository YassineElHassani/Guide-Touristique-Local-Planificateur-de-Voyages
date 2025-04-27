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
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{
    // Public routes
    public function index()
    {
        $events = events::orderBy('date', 'asc')->get();
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
        
        // Determine which view to use based on user role
        if (Auth::check()) {
            if (Auth::user()->role === 'travler') {
                return view('client.events.show', compact('event', 'reviews', 'hasReservation'));
            } elseif (Auth::user()->role === 'guide') {
                return view('guide.events.show', compact('event', 'reviews', 'hasReservation'));
            } elseif (Auth::user()->role === 'admin') {
                return view('admin.events.show', compact('event', 'reviews', 'hasReservation'));
            } 
        }
        
        // Default public view
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
            $events = events::orderBy('date', 'desc')->get();
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
            if (Auth::user()->role === 'guide') {
                return view('guide.events.create', compact('destinations'));
            } elseif (Auth::user()->role === 'admin') {
                return view('admin.events.create', compact('destinations'));
            }
        } catch (\Exception $e) {
            Log::error('Error loading destinations: ' . $e->getMessage());
            if (Auth::user()->role === 'guide') {
                return redirect()->route('guide.events.index')
                    ->with('error', 'Error loading destinations: ' . $e->getMessage());
            } else {
                return redirect()->route('admin.events.index')
                    ->with('error', 'Error loading destinations: ' . $e->getMessage());
            }
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'date' => 'required|date',
                'location' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'capacity' => 'nullable|integer|min:1',
                'requirements' => 'nullable|string',
                'itinerary' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

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

            if (Auth::user()->role === 'guide') {
                return redirect()->route('guide.events.index')
                ->with('success', 'Event created successfully.');
            } elseif (Auth::user()->role === 'admin') {
                return redirect()->route('admin.events.index')
                ->with('success', 'Event created successfully.');
            }

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
            
            if (Auth::user()->role === 'guide') {
                return view('guide.events.edit', compact('event', 'destinations'));
            } elseif (Auth::user()->role === 'admin') {
                return view('admin.events.edit', compact('event', 'destinations'));
            }
        } catch (\Exception $e) {
            Log::error('Error loading event for edit: ' . $e->getMessage());
            if (Auth::user()->role === 'guide') {
                return redirect()->route('guide.events.index')
                    ->with('error', 'Error loading event for edit: ' . $e->getMessage());
            } else {
                return redirect()->route('admin.events.index')
                    ->with('error', 'Error loading event for edit: ' . $e->getMessage());
            }
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'date' => 'required|date',
                'location' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_image' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $event = events::findOrFail($id);
            
            $data = [
                'name' => $request->name,
                'date' => $request->date,
                'location' => $request->location,
                'description' => $request->description,
                'price' => $request->price,
            ];

            // Handle image upload or removal if needed
            if ($request->has('remove_image') && $request->remove_image) {
                // Delete old image if exists
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                }
                $data['image'] = null;
            } elseif ($request->hasFile('image')) {
                // Delete old image if exists
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                }
                $imagePath = $request->file('image')->store('events', 'public');
                $data['image'] = $imagePath;
            }

            $event->update($data);

            if (Auth::user()->role === 'guide') {
                return redirect()->route('guide.events.index')
                    ->with('success', 'Event updated successfully.');
            } elseif (Auth::user()->role === 'admin') {
                return redirect()->route('admin.events.index')
                    ->with('success', 'Event updated successfully.');
            }
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
                $message = 'Cannot delete event with existing reservations. Cancel all reservations first.';
                
                if (Auth::user()->role === 'guide') {
                    return redirect()->route('guide.events.index')
                        ->with('error', $message);
                } else {
                    return redirect()->route('admin.events.index')
                        ->with('error', $message);
                }
            }
            
            // Delete image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            
            $event->delete();

            if (Auth::user()->role === 'guide') {
                return redirect()->route('guide.events.index')
                    ->with('success', 'Event deleted successfully.');
            } elseif (Auth::user()->role === 'admin') {
                return redirect()->route('admin.events.index')
                    ->with('success', 'Event deleted successfully.');
            }
            
        } catch (\Exception $e) {
            Log::error('Error deleting event: ' . $e->getMessage());
            
            if (Auth::user()->role === 'guide') {
                return redirect()->route('guide.events.index')
                    ->with('error', 'Error deleting event: ' . $e->getMessage());
            } else {
                return redirect()->route('admin.events.index')
                    ->with('error', 'Error deleting event: ' . $e->getMessage());
            }
        }
    }
}