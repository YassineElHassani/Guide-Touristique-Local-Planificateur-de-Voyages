<?php

namespace App\Http\Controllers;

use App\Models\events;
use App\Models\reviews;
use App\Models\reservations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\GuideMiddleware;
use App\Models\categories;

class GuideController extends Controller
{
    /**
     * The middleware assigned to the controller.
     *
     * @var array
     */
    protected array $middleware = [GuideMiddleware::class];
    
    public function home()
    {
        $user = Auth::user();
        
        // Get user's favorites
        $favorites = $user->favorites;
        
        // Get user's reservations
        $reservations = reservations::where('user_id', $user->id)->orderBy('date', 'desc')->get();
        
        // Get user's reviews
        $reviews = reviews::where('user_id', $user->id)->get();
        
        return view('guide.home', compact('user', 'favorites', 'reservations', 'reviews'));
    }

    /**
     * Show the guide dashboard.
     */
    public function dashboard()
    {
        // Since we can't filter events by guide yet, show all events
        $events = events::all();
        
        $stats = [
            'totalEvents' => $events->count(),
            'upcomingEvents' => $events->where('date', '>=', now())->count(),
            'totalReservations' => reservations::count(),
            'totalRevenue' => $this->calculateTotalRevenue(),
        ];
        
        // Get recent reservations
        $recentReservations = reservations::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('guide.dashboard', compact('stats', 'events', 'recentReservations'));
    }
    

    public function categories(Request $request) 
    {
        // $user = Auth::user();
        // $categories = categories::where('id', $user->id)->get();
        $categories = categories::all();

        return view('guide.categories.index', compact('categories'));
    }
    
    /**
     * Show the form for editing a category.
     */
    public function editCategory($id)
    {
        $user = Auth::user();
        $category = categories::where('id', $user->id)->findOrFail($id);
        return view('guide.categories.edit', compact('category'));
    }
    
    /**
     * Update the specified category.
     */
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $user = Auth::user();
        $category = categories::where('id', $user->id)->findOrFail($id);
        $category->name = $request->name;
        $category->save();
        
        return redirect()->route('guide.categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Show the guide's events.
     */
    public function events(Request $request)
    {
        // Initialize the query to filter events by the authenticated user's ID
        $eventsQuery = events::query()->where('id', Auth::id());
        
        // Apply search filters
        if ($request->has('search')) {
            $search = $request->search;
            $eventsQuery->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply date filters
        if ($request->has('date_from') && $request->date_from) {
            $eventsQuery->where('date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $eventsQuery->where('date', '<=', $request->date_to);
        }
        
        // Sort events
        $eventsQuery->orderBy('date', 'desc');
        
        // Get paginated results
        $events = $eventsQuery->paginate(10);
        
        return view('guide.events.index', compact('events'));
    }
    
    /**
     * Show all events from all guides.
     */
    public function allEvents(Request $request)
    {
        // Initialize the query to get all events
        $eventsQuery = events::query();
        
        // Apply search filters
        if ($request->has('search')) {
            $search = $request->search;
            $eventsQuery->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply date filters
        if ($request->has('date_from') && $request->date_from) {
            $eventsQuery->where('date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $eventsQuery->where('date', '<=', $request->date_to);
        }
        
        // Sort events
        $eventsQuery->orderBy('date', 'desc');
        
        // Get paginated results
        $events = $eventsQuery->paginate(10);
        
        return view('guide.events.all', compact('events'));
    }
    
    /**
     * Show reservations for the guide's events.
     */
    public function reservations()
    {
        // Get the authenticated user's events
        $userEvents = events::where('id', Auth::id())->pluck('id');
        
        // Show only reservations made to the user's events
        $reservations = reservations::whereIn('event_id', $userEvents)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('guide.reservations.index', compact('reservations'));
    }
    
    /**
     * Show a specific reservation.
     */
    public function showReservation($id)
    {
        $reservation = reservations::findOrFail($id);
        return view('guide.reservations.show', compact('reservation'));
    }
    
    /**
     * Store a new reservation (for guide direct bookings).
     */
    public function storeReservation(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'guests' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);
        
        $event = events::findOrFail($request->event_id);
        
        // Create the reservation
        $reservation = new reservations();
        $reservation->event_id = $request->event_id;
        $reservation->user_id = $request->user_id;
        $reservation->date = $request->date;
        $reservation->guests = $request->guests;
        // Note: total_price column doesn't exist in the reservations table
        // The price is stored in the events table
        $reservation->status = $request->status;
        $reservation->save();
        
        return redirect()->route('guide.reservations.index')
            ->with('success', 'Reservation created successfully');
    }
    
    /**
     * Update reservation status.
     */
    public function updateReservationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);
        
        $reservation = reservations::findOrFail($id);
        $reservation->update(['status' => $request->status]);
        
        return redirect()->back()
            ->with('success', 'Reservation status updated successfully.');
    }
    
    /**
     * Show reviews for events.
     */
    public function reviews()
    {
        // Get the authenticated user's events
        $userEvents = events::where('id', Auth::id())->pluck('id');
        
        // Show only reviews made for the user's events
        $reviews = reviews::whereIn('event_id', $userEvents)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('guide.reviews.index', compact('reviews'));
    }
    
    /**
     * Calculate total revenue from confirmed reservations
     */
    private function calculateTotalRevenue()
    {
        // Get confirmed reservations
        $confirmedReservations = reservations::where('status', 'confirmed')->get();
        
        // Calculate total revenue by multiplying event price by number of guests
        $totalRevenue = 0;
        foreach ($confirmedReservations as $reservation) {
            $event = events::find($reservation->event_id);
            if ($event) {
                $totalRevenue += $event->price * $reservation->guests;
            }
        }
        
        return $totalRevenue;
    }

    /**
     * Show statistics and performance metrics.
     */
    public function statistics()
    {
        // Get the authenticated user's ID
        $userId = Auth::id();
        
        // Get the events created by this guide (using id instead of user_id)
        $userEvents = events::where('id', $userId)->pluck('id')->toArray();
        
        // Monthly reservations for the past year (only for the guide's events)
        $monthlyReservations = DB::table('reservations')
            ->join('events', 'reservations.event_id', '=', 'events.id')
            ->select(DB::raw('MONTH(reservations.created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereIn('reservations.event_id', $userEvents)
            ->whereYear('reservations.created_at', '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        // Event popularity (reservation count per event - only for the guide's events)
        $eventPopularity = DB::table('events')
            ->leftJoin('reservations', 'events.id', '=', 'reservations.event_id')
            ->select('events.id', 'events.name', DB::raw('COUNT(reservations.id) as reservation_count'))
            ->whereIn('events.id', $userEvents)
            ->groupBy('events.id', 'events.name')
            ->orderBy('reservation_count', 'desc')
            ->get();
            
        // Average event rating (only for the guide's events)
        $eventRatings = DB::table('events')
            ->leftJoin('reviews', 'events.id', '=', 'reviews.event_id')
            ->select('events.id', 'events.name', DB::raw('AVG(reviews.rating) as average_rating'), DB::raw('COUNT(reviews.id) as review_count'))
            ->whereIn('events.id', $userEvents)
            ->groupBy('events.id', 'events.name')
            ->orderBy('average_rating', 'desc')
            ->get();
        
        return view('guide.statistics', compact('monthlyReservations', 'eventPopularity', 'eventRatings'));
    }
}