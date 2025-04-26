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
            // Log the error
            Log::error('Dashboard error: ' . $e->getMessage());

            // Provide fallback data
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

            // Initialize all variables needed in the view to prevent undefined variable errors
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
            
            // Empty destination categories
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
        $profile = $user; // Displaying user info directly from the users table

        // Get user's reservations
        $reservations = reservations::where('user_id', $id)->get();

        // Get user's reviews
        $reviews = reviews::where('user_id', $id)->get();

        // Get user's blogs if they exist
        $blogs = Blog::where('user_id', $id)->get();

        return view('admin.users.profile', compact('user', 'profile', 'reservations', 'reviews', 'blogs'));
    }

    private function getMonthlyStats()
    {
        $currentYear = Carbon::now()->year;

        // Get monthly user registrations
        $monthlyUsers = DB::table('users')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Get monthly reservations
        $monthlyReservations = DB::table('reservations')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Get monthly revenue
        $monthlyRevenue = DB::table('reservations')
            ->join('events', 'reservations.event_id', '=', 'events.id')
            ->select(DB::raw('MONTH(reservations.created_at) as month'), DB::raw('SUM(events.price) as total'))
            ->whereYear('reservations.created_at', $currentYear)
            ->where('reservations.status', 'confirmed')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
            
        // Get monthly events
        $monthlyEvents = DB::table('events')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
            
        // Get monthly destinations
        $monthlyDestinations = DB::table('destinations')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Format data for all 12 months
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

    /**
     * Display a listing of users.
     *
     * @return \Illuminate\View\View
     */
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        $profile = $user->first();

        // Get user's reservations
        $reservations = reservations::where('user_id', $id)->get();

        // Get user's reviews
        $reviews = reviews::where('user_id', $id)->get();

        // Get user's blogs if they exist
        $blogs = Blog::where('user_id', $id)->get();

        return view('admin.users.show', compact('user', 'profile', 'reservations', 'reviews', 'blogs'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

        // Handle picture upload
        if ($request->hasFile('picture')) {
            // Delete old picture if it exists
            if ($user->picture && Storage::disk('public')->exists($user->picture)) {
                Storage::disk('public')->delete($user->picture);
            }

            // Store new picture
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

    /**
     * Update user status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Update user role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->id === Auth::user()->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Display analytics dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function analytics()
    {
        // Monthly reservation counts for the past year
        $monthlyReservations = DB::table('reservations')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Destinations by category
        $destinationsByCategory = DB::table('destinations')
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();

        // Top rated destinations
        $topRatedDestinations = DB::table('destinations')
            ->join('reviews', 'destinations.id', '=', 'reviews.destination_id')
            ->select('destinations.id', 'destinations.name', DB::raw('AVG(reviews.rating) as average_rating'), DB::raw('COUNT(reviews.id) as review_count'))
            ->groupBy('destinations.id', 'destinations.name')
            ->having('review_count', '>=', 3) // Only include destinations with at least 3 reviews
            ->orderBy('average_rating', 'desc')
            ->take(5)
            ->get();

        // User registration trend
        $userRegistrationTrend = DB::table('users')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Revenue by month
        $revenueByMonth = DB::table('reservations')
            ->join('events', 'reservations.event_id', '=', 'events.id')
            ->select(DB::raw('MONTH(reservations.created_at) as month'), DB::raw('YEAR(reservations.created_at) as year'), DB::raw('SUM(events.price) as total'))
            ->where('reservations.status', '=', 'confirmed')
            ->where('reservations.created_at', '>=', Carbon::now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Most active users
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

    /**
     * Display site settings.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        // You can extend this method to load site settings from database
        return view('admin.settings');
    }

    /**
     * Update site settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string|max:1000',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'google_analytics_id' => 'nullable|string|max:20',
        ]);

        // Here you would update the settings in the database
        // This is placeholder code and would need actual implementation
        // using a Settings model or config repository

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Search functionality for admin panel
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->get('query');

        if (empty($query)) {
            return redirect()->back()->with('error', 'Please enter a search query.');
        }

        // Search users
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->take(5)
            ->get();

        // Search destinations
        $destinations = destinations::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get();

        // Search events
        $events = events::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get();

        // Search blogs
        $blogs = Blog::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->take(5)
            ->get();

        // search Categories
        $categories = categories::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get();

        return view('admin.search-results', compact('query', 'users', 'destinations', 'events', 'blogs', 'categories'));
    }

    /**
     * Show activity logs page
     * 
     * @return \Illuminate\View\View
     */
    public function activityLogs()
    {
        // This would depend on how you implement activity logging
        // For example, if using a ActivityLog model:
        // $logs = ActivityLog::orderBy('created_at', 'desc')->paginate(20);

        // Placeholder for now
        $logs = [];

        return view('admin.activity-logs', compact('logs'));
    }

    /**
     * Export data as CSV
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportData(Request $request)
    {
        $type = $request->get('type', 'users');
        $filename = $type . '_' . date('Y-m-d') . '.csv';

        switch ($type) {
            case 'users':
                $headers = ['ID', 'Name', 'Email', 'Role', 'Status', 'Created At'];
                $data = User::select('id', 'name', 'email', 'role', 'status', 'created_at')->get();
                break;

            case 'destinations':
                $headers = ['ID', 'Name', 'Address', 'Category', 'Created At'];
                $data = destinations::select('id', 'name', 'address', 'category', 'created_at')->get();
                break;

            case 'events':
                $headers = ['ID', 'Name', 'Date', 'Location', 'Price', 'Created At'];
                $data = events::select('id', 'name', 'date', 'location', 'price', 'created_at')->get();
                break;

            case 'reservations':
                $headers = ['ID', 'User ID', 'Event ID', 'Status', 'Created At'];
                $data = reservations::select('id', 'user_id', 'event_id', 'status', 'created_at')->get();
                break;

            default:
                return redirect()->back()->with('error', 'Invalid export type specified.');
        }

        // Create and return CSV file 
        // (This is simplified - in a real app you might use a package like Laravel Excel)
        $callback = function () use ($data, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($data as $row) {
                fputcsv($file, $row->toArray());
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}