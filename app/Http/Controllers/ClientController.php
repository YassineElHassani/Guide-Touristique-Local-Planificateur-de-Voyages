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
    
    public function events()
    {
        $events = events::all();
        return view('client.events.index', compact('events'));
    }

    public function eventDetails($id)
    {
        $event = events::findOrFail($id);
        return view('client.events.show', compact('event'));
    }

    public function favorites(Request $request)
    {
        // Get all user favorites with destination relationships
        $query = user_favorites::where('user_id', Auth::id())
            ->join('destinations', 'user_favorites.destination_id', '=', 'destinations.id')
            ->select('destinations.*', 'user_favorites.created_at as favorite_added_at');
        
        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('destinations.name', 'like', "%{$search}%")
                  ->orWhere('destinations.address', 'like', "%{$search}%")
                  ->orWhere('destinations.description', 'like', "%{$search}%");
            });
        }
        
        // Apply category filter if provided
        if ($request->has('category') && !empty($request->category)) {
            $query->where('destinations.category', $request->category);
        }
        
        // Apply sorting
        $sort = $request->query('sort', 'date_desc');
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('destinations.name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('destinations.name', 'desc');
                break;
            case 'date_asc':
                $query->orderBy('user_favorites.created_at', 'asc');
                break;
            case 'rating_desc':
                $query->orderBy('destinations.average_rating', 'desc');
                break;
            case 'rating_asc':
                $query->orderBy('destinations.average_rating', 'asc');
                break;
            case 'date_desc':
            default:
                $query->orderBy('user_favorites.created_at', 'desc');
                break;
        }
        
        // Paginate results
        $favorites = $query->paginate(9)->appends($request->query());
        
        // Handle view parameter
        $view = $request->query('view', 'grid');
        
        if ($view === 'list') {
            return view('client.favorites.list', compact('favorites'));
        }
        
        return view('client.favorites.index', compact('favorites'));
    }
    
    public function addToFavorites($id)
    {
        // Check if already in favorites
        $existingFavorite = user_favorites::where('user_id', Auth::id())
            ->where('destination_id', $id)
            ->first();
            
        if (!$existingFavorite) {
            user_favorites::create([
                'user_id' => Auth::id(),
                'destination_id' => $id
            ]);
            return back()->with('success', 'Destination added to favorites.');
        }
        
        return back()->with('info', 'This destination is already in your favorites.');
    }
    
    public function removeFromFavorites(Request $request, $id)
    {
        user_favorites::where('user_id', Auth::id())
            ->where('destination_id', $id)
            ->delete();
        
        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Destination removed from favorites successfully.',
            ]);
        }
            
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
            return redirect()->route('client.reservations.index')->with('error', 'You are not authorized to view this reservation.');
        }
        
        return view('client.reservations.show', compact('reservation'));
    }
    
    public function cancelReservation(Request $request, $id)
    {
        try {
            // Log request info for debugging
            info('Cancel reservation request', [
                'id' => $id,
                'is_ajax' => $request->ajax(),
                'wants_json' => $request->wantsJson(),
                'user_id' => Auth::id(),
                'headers' => $request->headers->all()
            ]);
            
            $reservation = reservations::findOrFail($id);
            
            // Check if the reservation belongs to the current user
            if ($reservation->user_id !== Auth::id()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to cancel this reservation.'
                    ], 403);
                }
                return redirect()->route('client.reservations.index')->with('error', 'You are not authorized to cancel this reservation.');
            }
            
            // Update reservation status
            $reservation->update(['status' => 'cancelled']);
            
            // Check if request is AJAX
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'message' => 'Reservation cancelled successfully.'
                ]);
            }
            
            return redirect()->route('client.reservations.index')->with('success', 'Reservation cancelled successfully.');
        } catch (\Exception $e) {
            info('Error cancelling reservation', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to cancel reservation: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('client.reservations.index')->with('error', 'Failed to cancel reservation. Please try again.');
        }
    }
    
    public function reviews(Request $request)
    {
        $query = reviews::where('user_id', Auth::id());
        
        // Apply filtering based on rating if provided
        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', $request->rating);
        }
        
        // Apply search if provided
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('event', function($eventQuery) use ($search) {
                    $eventQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('destination', function($destQuery) use ($search) {
                    $destQuery->where('name', 'like', "%{$search}%");
                });
            });
        }
        
        // Apply sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'rating_high':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'rating_low':
                    $query->orderBy('rating', 'asc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        // Get the reviews with pagination
        $reviews = $query->with(['event', 'destination'])->paginate(10);
        
        return view('client.reviews.index', compact('reviews'));
    }
    
    public function createReview(Request $request)
    {
        $event = null;
        $destination = null;
        
        // Check if we're reviewing an event or destination
        if ($request->has('event_id')) {
            $event = events::findOrFail($request->event_id);
        } elseif ($request->has('destination_id')) {
            $destination = destinations::findOrFail($request->destination_id);
        } else {
            return redirect()->back()->with('error', 'Please specify what you want to review.');
        }
        
        return view('client.reviews.create', compact('event', 'destination'));
    }
    
    public function showReview($id)
    {
        $review = reviews::with(['event', 'destination', 'user'])->findOrFail($id);
        
        // Check if the review belongs to the current user
        if ($review->user_id !== Auth::id()) {
            return redirect()->route('client.reviews')->with('error', 'You are not authorized to view this review.');
        }
        
        return view('client.reviews.show', compact('review'));
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