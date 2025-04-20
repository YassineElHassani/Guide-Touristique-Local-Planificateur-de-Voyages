<?php

namespace App\Http\Controllers;

use App\Models\itineraries;
use App\Models\destinations;
use App\Models\itinerary_destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ItinerariesController extends Controller
{
    /**
     * Display a listing of the user's itineraries.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your itineraries.');
        }
        
        $itineraries = itineraries::where('user_id', Auth::id())->get();
        return view('client.itineraries.index', compact('itineraries'));
    }

    /**
     * Show the form for creating a new itinerary.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to create itineraries.');
        }
        
        $destinations = destinations::all();
        return view('client.itineraries.create', compact('destinations'));
    }

    /**
     * Store a newly created itinerary in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to create itineraries.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'destination_ids' => 'required|array',
            'destination_ids.*' => 'exists:destinations,id',
            'days' => 'required|array',
            'days.*' => 'integer|min:1',
            'orders' => 'required|array',
            'orders.*' => 'integer|min:1',
        ]);
        
        // Create the itinerary
        $itinerary = itineraries::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        
        // Add destinations to the itinerary with day and order information
        foreach ($request->destination_ids as $index => $destinationId) {
            itinerary_destination::create([
                'itinerary_id' => $itinerary->id,
                'destination_id' => $destinationId,
                'day' => $request->days[$index],
                'order' => $request->orders[$index],
            ]);
        }
        
        return redirect()->route('client.itineraries.show', $itinerary->id)
            ->with('success', 'Itinerary created successfully.');
    }

    /**
     * Display the specified itinerary.
     */
    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view itineraries.');
        }
        
        $itinerary = itineraries::findOrFail($id);
        
        // Check if the itinerary belongs to the authenticated user
        if ($itinerary->user_id !== Auth::id()) {
            return redirect()->route('client.itineraries.index')
                ->with('error', 'You are not authorized to view this itinerary.');
        }
        
        // Get the destinations organized by day and order
        $destinations = $itinerary->destinations()
            ->orderBy('itinerary_destination.day')
            ->orderBy('itinerary_destination.order')
            ->get();
        
        // Group destinations by day
        $destinationsByDay = [];
        foreach ($destinations as $destination) {
            $day = $destination->pivot->day;
            if (!isset($destinationsByDay[$day])) {
                $destinationsByDay[$day] = [];
            }
            $destinationsByDay[$day][] = $destination;
        }
        
        return view('client.itineraries.show', compact('itinerary', 'destinationsByDay'));
    }

    /**
     * Show the form for editing the specified itinerary.
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to edit itineraries.');
        }
        
        $itinerary = itineraries::findOrFail($id);
        
        // Check if the itinerary belongs to the authenticated user
        if ($itinerary->user_id !== Auth::id()) {
            return redirect()->route('client.itineraries.index')
                ->with('error', 'You are not authorized to edit this itinerary.');
        }
        
        $destinations = destinations::all();
        $selectedDestinations = $itinerary->destinations()
            ->orderBy('itinerary_destination.day')
            ->orderBy('itinerary_destination.order')
            ->get();
        
        return view('client.itineraries.edit', compact('itinerary', 'destinations', 'selectedDestinations'));
    }

    /**
     * Update the specified itinerary in storage.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to update itineraries.');
        }
        
        $itinerary = itineraries::findOrFail($id);
        
        // Check if the itinerary belongs to the authenticated user
        if ($itinerary->user_id !== Auth::id()) {
            return redirect()->route('client.itineraries.index')
                ->with('error', 'You are not authorized to update this itinerary.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'destination_ids' => 'required|array',
            'destination_ids.*' => 'exists:destinations,id',
            'days' => 'required|array',
            'days.*' => 'integer|min:1',
            'orders' => 'required|array',
            'orders.*' => 'integer|min:1',
        ]);
        
        // Update the itinerary
        $itinerary->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        
        // Remove existing destinations
        itinerary_destination::where('itinerary_id', $itinerary->id)->delete();
        
        // Add updated destinations to the itinerary
        foreach ($request->destination_ids as $index => $destinationId) {
            itinerary_destination::create([
                'itinerary_id' => $itinerary->id,
                'destination_id' => $destinationId,
                'day' => $request->days[$index],
                'order' => $request->orders[$index],
            ]);
        }
        
        return redirect()->route('client.itineraries.show', $itinerary->id)
            ->with('success', 'Itinerary updated successfully.');
    }

    /**
     * Remove the specified itinerary from storage.
     */
    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to delete itineraries.');
        }
        
        $itinerary = itineraries::findOrFail($id);
        
        // Check if the itinerary belongs to the authenticated user
        if ($itinerary->user_id !== Auth::id()) {
            return redirect()->route('client.itineraries.index')
                ->with('error', 'You are not authorized to delete this itinerary.');
        }
        
        // Delete the itinerary
        $itinerary->delete();
        
        return redirect()->route('client.itineraries.index')
            ->with('success', 'Itinerary deleted successfully.');
    }

    /**
     * Share an itinerary.
     */
    public function share($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to share itineraries.');
        }
        
        $itinerary = itineraries::findOrFail($id);
        
        // Check if the itinerary belongs to the authenticated user
        if ($itinerary->user_id !== Auth::id()) {
            return redirect()->route('client.itineraries.index')
                ->with('error', 'You are not authorized to share this itinerary.');
        }
        
        // Generate a unique share token if one doesn't exist
        if (!$itinerary->share_token) {
            $itinerary->share_token = Str::random(32);
            $itinerary->save();
        }
        
        $shareUrl = route('shared.itinerary', $itinerary->share_token);
        
        return view('client.itineraries.share', compact('itinerary', 'shareUrl'));
    }

    /**
     * View a shared itinerary (public access).
     */
    public function showShared($token)
    {
        $itinerary = itineraries::where('share_token', $token)->firstOrFail();
        
        // Get the destinations organized by day and order
        $destinations = $itinerary->destinations()
            ->orderBy('itinerary_destination.day')
            ->orderBy('itinerary_destination.order')
            ->get();
        
        // Group destinations by day
        $destinationsByDay = [];
        foreach ($destinations as $destination) {
            $day = $destination->pivot->day;
            if (!isset($destinationsByDay[$day])) {
                $destinationsByDay[$day] = [];
            }
            $destinationsByDay[$day][] = $destination;
        }
        
        return view('itineraries.shared', compact('itinerary', 'destinationsByDay'));
    }

    /**
     * Generate a PDF of the itinerary.
     */
    public function generatePdf($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to export itineraries.');
        }
        
        $itinerary = itineraries::findOrFail($id);
        
        // Check if the itinerary belongs to the authenticated user
        if ($itinerary->user_id !== Auth::id()) {
            return redirect()->route('client.itineraries.index')
                ->with('error', 'You are not authorized to export this itinerary.');
        }
        
        // Get the destinations organized by day and order
        $destinations = $itinerary->destinations()
            ->orderBy('itinerary_destination.day')
            ->orderBy('itinerary_destination.order')
            ->get();
        
        // Group destinations by day
        $destinationsByDay = [];
        foreach ($destinations as $destination) {
            $day = $destination->pivot->day;
            if (!isset($destinationsByDay[$day])) {
                $destinationsByDay[$day] = [];
            }
            $destinationsByDay[$day][] = $destination;
        }
        
        // Generate PDF using a PDF library (like DomPDF)
        // This is a placeholder - you would need to implement actual PDF generation
        
        return view('client.itineraries.pdf', compact('itinerary', 'destinationsByDay'));
    }
}