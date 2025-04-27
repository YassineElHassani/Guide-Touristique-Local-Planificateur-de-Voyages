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
    // protected array $middleware = [GuideMiddleware::class];
    
    public function home()
    {
        $user = Auth::user();
        
        $favorites = $user->favorites;
        
        $reservations = reservations::where('user_id', $user->id)->orderBy('date', 'desc')->get();
        
        $reviews = reviews::where('user_id', $user->id)->get();
        
        return view('guide.home', compact('user', 'favorites', 'reservations', 'reviews'));
    }

    public function dashboard()
    {
        $events = events::all();
        
        $stats = [
            'totalEvents' => $events->count(),
            'upcomingEvents' => $events->where('date', '>=', now())->count(),
            'totalReservations' => reservations::count(),
            'totalRevenue' => $this->calculateTotalRevenue(),
        ];
        
        $recentReservations = reservations::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('guide.dashboard', compact('stats', 'events', 'recentReservations'));
    }
    

    public function categories(Request $request) 
    {
        $categories = categories::all();

        return view('guide.categories.index', compact('categories'));
    }
    
    public function editCategory($id)
    {
        $user = Auth::user();
        $category = categories::where('id', $user->id)->findOrFail($id);
        return view('guide.categories.edit', compact('category'));
    }
    
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

    public function events(Request $request)
    {
        $eventsQuery = events::query()->where('id', Auth::id());
        
        if ($request->has('search')) {
            $search = $request->search;
            $eventsQuery->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('date_from') && $request->date_from) {
            $eventsQuery->where('date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $eventsQuery->where('date', '<=', $request->date_to);
        }
        
        $eventsQuery->orderBy('date', 'desc');
        
        $events = $eventsQuery->paginate(10);
        
        return view('guide.events.index', compact('events'));
    }
    
    public function allEvents(Request $request)
    {
        $eventsQuery = events::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $eventsQuery->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('date_from') && $request->date_from) {
            $eventsQuery->where('date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $eventsQuery->where('date', '<=', $request->date_to);
        }
        
        $eventsQuery->orderBy('date', 'desc');
        
        $events = $eventsQuery->paginate(10);
        
        return view('guide.events.all', compact('events'));
    }
    
    public function reservations()
    {
        $userEvents = events::where('id', Auth::id())->pluck('id');
        
        $reservations = reservations::whereIn('event_id', $userEvents)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('guide.reservations.index', compact('reservations'));
    }
    
    public function showReservation($id)
    {
        $reservation = reservations::findOrFail($id);
        return view('guide.reservations.show', compact('reservation'));
    }
    
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
        
        $reservation = new reservations();
        $reservation->event_id = $request->event_id;
        $reservation->user_id = $request->user_id;
        $reservation->date = $request->date;
        $reservation->guests = $request->guests;
        $reservation->status = $request->status;
        $reservation->save();
        
        return redirect()->route('guide.reservations.index')
            ->with('success', 'Reservation created successfully');
    }
    
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
    
    public function reviews()
    {
        $userEvents = events::where('id', Auth::id())->pluck('id');
        
        $reviews = reviews::whereIn('event_id', $userEvents)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('guide.reviews.index', compact('reviews'));
    }
    
    private function calculateTotalRevenue()
    {
        $confirmedReservations = reservations::where('status', 'confirmed')->get();
        
        $totalRevenue = 0;
        foreach ($confirmedReservations as $reservation) {
            $event = events::find($reservation->event_id);
            if ($event) {
                $totalRevenue += $event->price * $reservation->guests;
            }
        }
        
        return $totalRevenue;
    }

    public function statistics()
    {
        $userId = Auth::id();
        
        $userEvents = events::where('id', $userId)->pluck('id')->toArray();
        
        $monthlyReservations = DB::table('reservations')
            ->join('events', 'reservations.event_id', '=', 'events.id')
            ->select(DB::raw('MONTH(reservations.created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereIn('reservations.event_id', $userEvents)
            ->whereYear('reservations.created_at', '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        $eventPopularity = DB::table('events')
            ->leftJoin('reservations', 'events.id', '=', 'reservations.event_id')
            ->select('events.id', 'events.name', DB::raw('COUNT(reservations.id) as reservation_count'))
            ->whereIn('events.id', $userEvents)
            ->groupBy('events.id', 'events.name')
            ->orderBy('reservation_count', 'desc')
            ->get();
            
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