<?php

namespace App\Http\Controllers;

use App\Models\destinations;
use App\Models\events;
use App\Models\itineraries;
use App\Models\reservations;
use App\Models\reviews;
use App\Models\user_favorites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ClientMiddleware;

class ClientController extends Controller
{
    protected array $middleware = [ClientMiddleware::class];

    public function home() {
        return view('client.home');
    }
    
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get user's favorites
        $favorites = $user->favorites;
        
        // Get user's itineraries
        $itineraries = itineraries::where('user_id', $user->id)->get();
        
        // Get user's reservations
        $reservations = reservations::where('user_id', $user->id)->orderBy('date', 'desc')->get();
        
        // Get user's reviews
        $reviews = reviews::where('user_id', $user->id)->get();
        
        return view('client.home', compact('user', 'favorites', 'itineraries', 'reservations', 'reviews'));
    }
    
    public function favorites()
    {
        $favorites = Auth::user()->favorites;
        return view('client.favorites.index', compact('favorites'));
    }
    
    public function addToFavorites($id)
    {
        // Check if already in favorites
        $existingFavorite = user_favorites::where('user_id', Auth::id())->first();
            
        if (!$existingFavorite) {
            user_favorites::create([
                'user_id' => Auth::id(),
                'destination_id' => $id
            ]);
            return back()->with('success', 'Destination added to favorites.');
        }
        
        return back()->with('info', 'This destination is already in your favorites.');
    }
    
    public function removeFromFavorites($id)
    {
        user_favorites::where('user_id', Auth::id())->where('destination_id', $id)->delete();
            
        return back()->with('success', 'Destination removed from favorites.');
    }
    
    public function reservations()
    {
        $reservations = reservations::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
            
        return view('client.reservations.index', compact('reservations'));
    }
    
    public function showReservation($id)
    {
        $reservation = reservations::findOrFail($id);
        
        // Check if the reservation belongs to the current user
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->route('client.reservations')->with('error', 'You are not authorized to view this reservation.');
        }
        
        return view('client.reservations.show', compact('reservation'));
    }
    
    public function cancelReservation($id)
    {
        $reservation = reservations::findOrFail($id);
        
        // Check if the reservation belongs to the current user
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->route('client.reservations')->with('error', 'You are not authorized to cancel this reservation.');
        }
        
        $reservation->update(['status' => 'cancelled']);
        
        return redirect()->route('client.reservations')->with('success', 'Reservation cancelled successfully.');
    }
    
    public function reviews()
    {
        $reviews = reviews::where('user_id', Auth::id())->get();
        return view('client.reviews.index', compact('reviews'));
    }
    
    public function editReview($id)
    {
        $review = reviews::findOrFail($id);
        
        // Check if the review belongs to the current user
        if ($review->user_id !== Auth::id()) {
            return redirect()->route('client.reviews')->with('error', 'You are not authorized to edit this review.');
        }
        
        return view('client.reviews.edit', compact('review'));
    }
    
    public function updateReview(Request $request, $id)
    {
        $review = reviews::findOrFail($id);
        
        // Check if the review belongs to the current user
        if ($review->user_id !== Auth::id()) {
            return redirect()->route('client.reviews')->with('error', 'You are not authorized to update this review.');
        }
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);
        
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        
        return redirect()->route('client.reviews')->with('success', 'Review updated successfully.');
    }
    
    public function deleteReview($id)
    {
        $review = reviews::findOrFail($id);
        
        // Check if the review belongs to the current user
        if ($review->user_id !== Auth::id()) {
            return redirect()->route('client.reviews')->with('error', 'You are not authorized to delete this review.');
        }
        
        $review->delete();
        
        return redirect()->route('client.reviews')->with('success', 'Review deleted successfully.');
    }
}