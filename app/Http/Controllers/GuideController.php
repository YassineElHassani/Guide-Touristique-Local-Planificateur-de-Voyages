<?php

namespace App\Http\Controllers;

use App\Models\events;
use App\Models\reviews;
use App\Models\reservations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\GuideMiddleware;

class GuideController extends Controller
{
    /**
     * The middleware assigned to the controller.
     *
     * @var array
     */
    protected array $middleware = [GuideMiddleware::class];
    
    /**
     * Show the guide dashboard.
     */
    public function dashboard()
    {
        // For a real application, you would filter events by the current guide's ID
        // Since we don't have a direct relation in the database, we'll show all events for now
        $events = events::all();
        
        // Calculate stats
        $stats = [
            'totalEvents' => $events->count(),
            'upcomingEvents' => $events->where('date', '>=', now())->count(),
            'totalReservations' => reservations::count(), // In a real app, filter by guide's events
            'totalRevenue' => $events->sum('price'), // Simplified - in a real app would sum actual bookings
        ];
        
        // Get recent reservations
        $recentReservations = reservations::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('guide.dashboard', compact('stats', 'events', 'recentReservations'));
    }
    
    /**
     * Show the guide's events.
     */
    public function events()
    {
        // For a real application, you would filter events by the current guide's ID
        $events = events::all();
        return view('guide.events.index', compact('events'));
    }
    
    /**
     * Show reservations for the guide's events.
     */
    public function reservations()
    {
        // For a real application, you would filter reservations by the guide's events
        $reservations = reservations::all();
        return view('guide.reservations.index', compact('reservations'));
    }
    
    /**
     * Show reviews for the guide's events.
     */
    public function reviews()
    {
        // For a real application, you would filter reviews by the guide's events
        $reviews = reviews::where('event_id', '!=', null)->get();
        return view('guide.reviews.index', compact('reviews'));
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
        
        return redirect()->route('guide.reservations')
            ->with('success', 'Reservation status updated successfully.');
    }
    
    /**
     * Show statistics and performance metrics.
     */
    public function statistics()
    {
        // Monthly reservations for the past year
        $monthlyReservations = DB::table('reservations')
            ->join('events', 'reservations.event_id', '=', 'events.id')
            ->select(DB::raw('MONTH(reservations.created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('reservations.created_at', '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        // Event popularity (reservation count per event)
        $eventPopularity = DB::table('events')
            ->leftJoin('reservations', 'events.id', '=', 'reservations.event_id')
            ->select('events.id', 'events.name', DB::raw('COUNT(reservations.id) as reservation_count'))
            ->groupBy('events.id', 'events.name')
            ->orderBy('reservation_count', 'desc')
            ->get();
            
        // Average event rating
        $eventRatings = DB::table('events')
            ->leftJoin('reviews', 'events.id', '=', 'reviews.event_id')
            ->select('events.id', 'events.name', DB::raw('AVG(reviews.rating) as average_rating'), DB::raw('COUNT(reviews.id) as review_count'))
            ->groupBy('events.id', 'events.name')
            ->orderBy('average_rating', 'desc')
            ->get();
        
        return view('guide.statistics', compact('monthlyReservations', 'eventPopularity', 'eventRatings'));
    }
}