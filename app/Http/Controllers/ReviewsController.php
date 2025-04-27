<?php

namespace App\Http\Controllers;

use App\Models\reviews;
use App\Models\destinations;
use App\Models\events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to leave a review.');
        }
        
        $request->validate([
            'destination_id' => 'nullable|exists:destinations,id',
            'event_id' => 'nullable|exists:events,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);
        
        if (!$request->destination_id && !$request->event_id) {
            return back()->with('error', 'A destination or event must be specified.');
        }
        
        reviews::create([
            'user_id' => Auth::id(),
            'destination_id' => $request->destination_id,
            'event_id' => $request->event_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        
        if ($request->destination_id) {
            return redirect()->route('destinations.show', $request->destination_id)
                ->with('success', 'Review submitted successfully.');
        } else {
            return redirect()->route('events.show', $request->event_id)
                ->with('success', 'Review submitted successfully.');
        }
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to update a review.');
        }
        
        $review = reviews::findOrFail($id);
        
        if ($review->user_id !== Auth::id()) {
            return back()->with('error', 'You are not authorized to update this review.');
        }
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);
        
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        
        if ($review->destination_id) {
            return redirect()->route('destinations.show', $review->destination_id)
                ->with('success', 'Review updated successfully.');
        } else {
            return redirect()->route('events.show', $review->event_id)
                ->with('success', 'Review updated successfully.');
        }
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to delete a review.');
        }
        
        $review = reviews::findOrFail($id);
        
        if ($review->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return back()->with('error', 'You are not authorized to delete this review.');
        }
        
        $destinationId = $review->destination_id;
        $eventId = $review->event_id;
        
        $review->delete();
        
        if (request()->routeIs('admin.*')) {
            return redirect()->route('admin.reviews.index')
                ->with('success', 'Review deleted successfully.');
        } elseif ($destinationId) {
            return redirect()->route('destinations.show', $destinationId)
                ->with('success', 'Review deleted successfully.');
        } else {
            return redirect()->route('events.show', $eventId)
                ->with('success', 'Review deleted successfully.');
        }
    }

    public function adminIndex()
    {
        $reviews = reviews::with(['user', 'destination', 'event'])->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }
    
    public function show($id)
    {
        $review = reviews::with(['user', 'destination', 'event'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }
}