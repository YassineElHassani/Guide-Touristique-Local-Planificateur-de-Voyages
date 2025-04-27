<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blog;
use App\Models\destinations;
use App\Models\events;
use App\Models\reviews;
use App\Models\reservations;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with statistics.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        try {
            // Get count of various entities for dashboard statistics
            $stats = [
                'users' => User::count(),
                'guides' => User::where('role', 'guide')->count(),
                'destinations' => destinations::count(),
                'events' => events::count(),
                'reservations' => reservations::count(),
                'reviews' => reviews::count(),
                'blogs' => Blog::count(),
                'categories' => categories::count(),
            ];

            // Get recent users
            $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

            // Get recent destinations
            $recentDestinations = destinations::orderBy('created_at', 'desc')->take(5)->get();

            // Get recent events
            $recentEvents = events::orderBy('created_at', 'desc')->take(5)->get();

            // Get recent reservations
            $recentReservations = reservations::with(['user', 'event'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Get recent reviews
            $recentReviews = reviews::with(['user', 'destination', 'event'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Get monthly statistics
            $monthlyStats = $this->getMonthlyStats();
            
            // Get destination categories
            $destinationCategories = DB::table('destinations')
                ->select('category', DB::raw('COUNT(*) as count'))
                ->groupBy('category')
                ->orderBy('count', 'desc')
                ->get()
                ->map(function($item) {
                    return [$item->category, $item->count];
                })
                ->toArray();

            return view('admin.dashboard', compact(
                'stats',
                'recentUsers',
                'recentDestinations',
                'recentEvents',
                'recentReservations',
                'recentReviews',
                'monthlyStats',
                'destinationCategories'
            ));
        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            $stats = [
                'users' => 0,
                'guides' => 0,
                'destinations' => 0,
                'events' => 0,
                'reservations' => 0,
                'reviews' => 0,
                'blogs' => 0,
                'categories' => 0,
            ];
            $recentUsers = collect([]);
            $recentDestinations = collect([]);
            $recentEvents = collect([]);
            $recentReservations = collect([]);
            $recentReviews = collect([]);
            $monthlyStats = [
                1 => ['users' => 0, 'reservations' => 0, 'revenue' => 0, 'events' => 0, 'destinations' => 0],
                2 => ['users' => 0, 'reservations' => 0, 'revenue' => 0, 'events' => 0, 'destinations' => 0],
                3 => ['users' => 0, 'reservations' => 0, 'revenue' => 0, 'events' => 0, 'destinations' => 0],
                4 => ['users' => 0, 'reservations' => 0, 'revenue' => 0, 'events' => 0, 'destinations' => 0],
                5 => ['users' => 0, 'reservations' => 0, 'revenue' => 0, 'events' => 0, 'destinations' => 0],
                6 => ['users' => 0, 'reservations' => 0, 'revenue' => 0, 'events' => 0, 'destinations' => 0],
                7 => ['users' => 0, 'reservations' => 0, 'revenue' => 0, 'events' => 0, 'destinations' => 0],
                8 => ['users' => 0, 'reservations' => 0, 'revenue' => 0, 'events' => 0, 'destinations' => 0],
                9 => ['users' => 0, 'reservations' => 0, 'revenue' => 0, 'events' => 0, 'destinations' => 0],
                10 => ['users' => 0, 'reservations' => 0, 'revenue' => 0, 'events' => 0, 'destinations' => 0],
                11 => ['users' => 0, 'reservations' => 0, 'revenue' => 0, 'events' => 0, 'destinations' => 0],
                12 => ['users' => 0, 'reservations' => 0, 'revenue' => 0, 'events' => 0, 'destinations' => 0],
            ];
            
            $destinationCategories = [];

            return view('admin.dashboard', compact(
                'stats',
                'recentUsers',
                'recentDestinations',
                'recentEvents',
                'recentReservations',
                'recentReviews',
                'monthlyStats',
                'destinationCategories'
            ))->with('error', 'There was an error loading the dashboard data. Please try again later.');
        }
    }

    public function userProfile($id)
    {
        $user = User::findOrFail($id);
        $profile = $user;

        $reservations = reservations::where('user_id', $id)->get();

        $reviews = reviews::where('user_id', $id)->get();

        $blogs = Blog::where('user_id', $id)->get();

        return view('admin.users.profile', compact('user', 'profile', 'reservations', 'reviews', 'blogs'));
    }

    private function getMonthlyStats()
    {
        $currentYear = Carbon::now()->year;

        $monthlyUsers = DB::table('users')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $monthlyReservations = DB::table('reservations')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $monthlyRevenue = DB::table('reservations')
            ->join('events', 'reservations.event_id', '=', 'events.id')
            ->select(DB::raw('MONTH(reservations.created_at) as month'), DB::raw('SUM(events.price) as total'))
            ->whereYear('reservations.created_at', $currentYear)
            ->where('reservations.status', 'confirmed')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
            
        $monthlyEvents = DB::table('events')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
            
        $monthlyDestinations = DB::table('destinations')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $formattedData = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedData[$i] = [
                'users' => $monthlyUsers[$i] ?? 0,
                'reservations' => $monthlyReservations[$i] ?? 0,
                'revenue' => $monthlyRevenue[$i] ?? 0,
                'events' => $monthlyEvents[$i] ?? 0,
                'destinations' => $monthlyDestinations[$i] ?? 0,
            ];
        }

        return $formattedData;
    }

    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        $profile = $user->first();

        $reservations = reservations::where('user_id', $id)->get();

        $reviews = reviews::where('user_id', $id)->get();

        $blogs = Blog::where('user_id', $id)->get();

        return view('admin.users.show', compact('user', 'profile', 'reservations', 'reviews', 'blogs'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,guide,travler',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female',
            'birthday' => 'nullable|date',
            'phone' => 'string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,guide,travler',
            'password' => 'string|min:8',
            'status' => 'in:active,inactive',
        ]);

        if ($request->hasFile('picture')) {
            if ($user->picture && Storage::disk('public')->exists($user->picture)) {
                Storage::disk('public')->delete($user->picture);
            }

            $newPicturePath = $request->file('picture')->store('avatars', 'public');
        } else {
            $newPicturePath = $user->picture;
        }

        $user->update([
            'picture' => $newPicturePath,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.users.show', $id)
            ->with('success', 'User updated successfully.');
    }

    public function updateUserStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::findOrFail($id);
        $user->update(['status' => $request->status]);

        return redirect()->route('admin.users.show', $id)
            ->with('success', 'User status updated successfully.');
    }

    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,guide,travler',
        ]);

        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return redirect()->route('admin.users.show', $id)
            ->with('success', 'User role updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::user()->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function analytics()
    {
        $monthlyReservations = DB::table('reservations')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $destinationsByCategory = DB::table('destinations')
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();

        $topRatedDestinations = DB::table('destinations')
            ->join('reviews', 'destinations.id', '=', 'reviews.destination_id')
            ->select('destinations.id', 'destinations.name', DB::raw('AVG(reviews.rating) as average_rating'), DB::raw('COUNT(reviews.id) as review_count'))
            ->groupBy('destinations.id', 'destinations.name')
            ->having('review_count', '>=', 3)
            ->orderBy('average_rating', 'desc')
            ->take(5)
            ->get();

        $userRegistrationTrend = DB::table('users')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $revenueByMonth = DB::table('reservations')
            ->join('events', 'reservations.event_id', '=', 'events.id')
            ->select(DB::raw('MONTH(reservations.created_at) as month'), DB::raw('YEAR(reservations.created_at) as year'), DB::raw('SUM(events.price) as total'))
            ->where('reservations.status', '=', 'confirmed')
            ->where('reservations.created_at', '>=', Carbon::now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $mostActiveUsers = DB::table('users')
            ->leftJoin('reservations', 'users.id', '=', 'reservations.user_id')
            ->leftJoin('reviews', 'users.id', '=', 'reviews.user_id')
            ->select(
                'users.id',
                'users.name',
                DB::raw('(SELECT COUNT(*) FROM reservations WHERE user_id = users.id) as reservation_count'),
                DB::raw('(SELECT COUNT(*) FROM reviews WHERE user_id = users.id) as review_count')
            )
            ->groupBy('users.id', 'users.name')
            ->orderByRaw('(reservation_count + review_count + itinerary_count) DESC')
            ->take(10)
            ->get();

        return view('admin.analytics', compact(
            'monthlyReservations',
            'destinationsByCategory',
            'topRatedDestinations',
            'userRegistrationTrend',
            'revenueByMonth',
            'mostActiveUsers'
        ));
    }
    
    public function search(Request $request)
    {
        $query = $request->get('query');

        if (empty($query)) {
            return redirect()->back()->with('error', 'Please enter a search query.');
        }

        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->take(5)
            ->get();

        $destinations = destinations::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get();

        $events = events::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get();

        $blogs = Blog::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->take(5)
            ->get();

        $categories = categories::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get();

        return view('admin.search-results', compact('query', 'users', 'destinations', 'events', 'blogs', 'categories'));
    }

}