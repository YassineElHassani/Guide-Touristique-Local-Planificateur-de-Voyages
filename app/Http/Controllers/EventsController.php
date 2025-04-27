<?php

namespace App\Http\Controllers;

use App\Models\categories;
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
    public function indexVisit()
    {
        try {
            // Get upcoming events
            $events = events::where('date', '>=', now())
                ->orderBy('date', 'asc')
                ->paginate(12);
            
            // Get categories for filter options
            $categories = categories::all();
            
            // Get min/max prices for filter options
            $minMaxPrices = events::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();
            
            // Get locations for filter options
            $locations = events::select('location')->distinct()->pluck('location');
            
            return view('events.index', compact('events', 'categories', 'minMaxPrices', 'locations'));
        } catch (\Exception $e) {
            Log::error('Error loading events: ' . $e->getMessage());
            return view('events.index')
                ->with('error', 'Error loading events.');
        }
    }

    public function showVisit($id)
    {
        try {
            // Find the event by ID
            $event = events::findOrFail($id);
            
            // Get reviews for this event
            $reviews = reviews::where('event_id', $id)->get();
            
            // Calculate average rating
            $averageRating = $reviews->avg('rating');
            
            // Count reservations to determine available spots
            $reservationsCount = reservations::where('event_id', $id)
                ->where('status', 'confirmed')
                ->count();
            
            $availableSpots = ($event->capacity ?? 20) - $reservationsCount;
            
            // Check if current user has a reservation
            $hasReservation = false;
            if (Auth::check()) {
                $hasReservation = reservations::where('user_id', Auth::id())
                    ->where('event_id', $id)
                    ->exists();
            }
            
            $guide = null;
            if (isset($event->user_id)) {
                $guide = \App\Models\User::find($event->user_id);
            }
            
            $similarEvents = events::where('id', '!=', $id)
                ->where(function($query) use ($event) {
                    if (isset($event->category_id)) {
                        $query->where('category_id', $event->category_id);
                    }
                    $query->orWhere('location', 'like', '%' . explode(',', $event->location)[0] . '%');
                })
                ->where('date', '>=', now())
                ->orderBy('date')
                ->take(3)
                ->get();
            
            return view('events.show', compact(
                'event', 
                'reviews', 
                'averageRating', 
                'reservationsCount',
                'availableSpots',
                'hasReservation',
                'guide',
                'similarEvents'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error showing event: ' . $e->getMessage());
            return redirect()->route('events.index')
                ->with('error', 'Event not found or has been removed.');
        }
    }

    public function show($id)
    {
        $event = events::findOrFail($id);
        $reviews = reviews::where('event_id', $id)->get();
        
        $hasReservation = false;
        if (Auth::check()) {
            $hasReservation = reservations::where('user_id', Auth::id())
                ->where('event_id', $id)
                ->exists();
        }
        
        if (Auth::check()) {
            if (Auth::user()->role === 'travler') {
                return view('client.events.show', compact('event', 'reviews', 'hasReservation'));
            } elseif (Auth::user()->role === 'guide') {
                return view('guide.events.show', compact('event', 'reviews', 'hasReservation'));
            } elseif (Auth::user()->role === 'admin') {
                return view('admin.events.show', compact('event', 'reviews', 'hasReservation'));
            } 
        }
        
        return view('events.show', compact('event', 'reviews', 'hasReservation'));
    }

    public function search(Request $request)
    {
        try {
            // Get filter parameters
            $query = $request->input('query');
            $dateFilter = $request->input('date');
            $priceMin = $request->input('price_min');
            $priceMax = $request->input('price_max');
            $categoryId = $request->input('category_id');
            $location = $request->input('location');
            $sortBy = $request->input('sort_by', 'date_asc'); // Default sort by date ascending
            
            // Start building the query
            $events = events::query();
            
            // Apply text search filter
            if (!empty($query)) {
                $events->where(function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%')
                      ->orWhere('description', 'like', '%' . $query . '%')
                      ->orWhere('location', 'like', '%' . $query . '%');
                });
            }
            
            // Apply date filter
            if (!empty($dateFilter)) {
                $events->whereDate('date', '=', $dateFilter);
            } else {
                // Default to future events only
                $events->where('date', '>=', now());
            }
            
            // Apply price range filter
            if (!empty($priceMin)) {
                $events->where('price', '>=', $priceMin);
            }
            
            if (!empty($priceMax)) {
                $events->where('price', '<=', $priceMax);
            }
            
            // Apply category filter
            if (!empty($categoryId)) {
                $events->where('category_id', $categoryId);
            }
            
            // Apply location filter
            if (!empty($location)) {
                $events->where('location', 'like', '%' . $location . '%');
            }
            
            // Apply sorting
            switch ($sortBy) {
                case 'price_asc':
                    $events->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $events->orderBy('price', 'desc');
                    break;
                case 'date_desc':
                    $events->orderBy('date', 'desc');
                    break;
                case 'name_asc':
                    $events->orderBy('name', 'asc');
                    break;
                case 'date_asc':
                default:
                    $events->orderBy('date', 'asc');
                    break;
            }
            
            // Get categories for filter options
            $categories = categories::all();
            
            // Get price range for filter options
            $minMaxPrices = events::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();
            
            // Get locations for filter options
            $locations = events::select('location')->distinct()->pluck('location');
            
            // Get paginated results
            $events = $events->paginate(9);
            
            // Pass data to the view
            return view('events.search_results', compact(
                'events',
                'query',
                'dateFilter',
                'priceMin',
                'priceMax',
                'categoryId',
                'location',
                'sortBy',
                'categories',
                'minMaxPrices',
                'locations'
            ));
        } catch (\Exception $e) {
            Log::error('Error searching events: ' . $e->getMessage());
            return redirect()->route('events.index')
                ->with('error', 'An error occurred while searching for events.');
        }
    }

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

            if ($request->has('remove_image') && $request->remove_image) {
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                }
                $data['image'] = null;
            } elseif ($request->hasFile('image')) {
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