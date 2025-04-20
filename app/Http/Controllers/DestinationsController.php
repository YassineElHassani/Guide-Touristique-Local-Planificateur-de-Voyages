<?php

namespace App\Http\Controllers;

use App\Models\destinations;
use App\Models\categories;
use App\Models\reviews;
use App\Models\user_favorites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DestinationsController extends Controller
{
    /**
     * Display a listing of the destinations.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $destinations = destinations::all();
        $categories = categories::all();
        return view('destinations.index', compact('destinations', 'categories'));
    }

    /**
     * Display a listing of the destinations by category.
     *
     * @param  string  $category
     * @return \Illuminate\View\View
     */
    public function byCategory($category)
    {
        $destinations = destinations::where('category', $category)->get();
        $categoryObj = categories::where('name', $category)->first();
        return view('destinations.by_category', compact('destinations', 'categoryObj'));
    }

    /**
     * Display the specified destination.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $destination = destinations::findOrFail($id);
        $reviews = reviews::where('destination_id', $id)->get();
        
        // Check if user has favorited this destination
        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = user_favorites::where('user_id', Auth::id())
                ->where('destination_id', $id)
                ->exists();
        }
        
        return view('destinations.show', compact('destination', 'reviews', 'isFavorite'));
    }

    /**
     * Search for destinations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $categoryFilter = $request->input('category');
        
        $destinations = destinations::query();
        
        if (!empty($query)) {
            $destinations->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('address', 'like', '%' . $query . '%');
            });
        }
        
        if (!empty($categoryFilter)) {
            $destinations->where('category', $categoryFilter);
        }
        
        $destinations = $destinations->get();
        $categories = categories::all();
        
        return view('destinations.search_results', compact('destinations', 'query', 'categoryFilter', 'categories'));
    }

    /**
     * Add destination to user favorites.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToFavorites($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add favorites.');
        }
        
        // Check if already favorited
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

    /**
     * Remove destination from user favorites.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFromFavorites($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to manage favorites.');
        }
        
        user_favorites::where('user_id', Auth::id())
            ->where('destination_id', $id)
            ->delete();
            
        return back()->with('success', 'Destination removed from favorites.');
    }

    /**
     * Display featured destinations.
     *
     * @return \Illuminate\View\View
     */
    public function featured()
    {
        // For simplicity, just showing some destinations as featured
        // In a real app, you might have a 'featured' flag in the database
        $featuredDestinations = destinations::take(6)->get();
        return view('destinations.featured', compact('featuredDestinations'));
    }

    /*
     * Admin Methods
     */

    /**
     * Display a listing of all destinations for admin.
     *
     * @return \Illuminate\View\View
     */
    public function adminIndex()
    {
        try {
            $destinations = destinations::all();
            return view('admin.destinations', compact('destinations'));
        } catch (\Exception $e) {
            Log::error('Error loading destinations: ' . $e->getMessage());
            return redirect()->route('admin.dashboard.index')
                ->with('error', 'Error loading destinations: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new destination.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try {
            $categories = categories::all();
            return view('admin.destinations.create', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error loading categories: ' . $e->getMessage());
            return redirect()->route('admin.destinations.index')
                ->with('error', 'Error loading categories: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created destination in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'address' => 'required|string',
                'category' => 'required|string',
                'coordinates' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'category' => $request->category,
                'coordinates' => $request->coordinates,
            ];

            // Handle image upload if present
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/destinations', $imageName);
                $data['image'] = $imageName;
            }

            destinations::create($data);

            return redirect()->route('admin.destinations.index')
                ->with('success', 'Destination created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating destination: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating destination: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified destination.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $destination = destinations::findOrFail($id);
            $categories = categories::all();
            return view('admin.destinations.edit', compact('destination', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error loading destination for edit: ' . $e->getMessage());
            return redirect()->route('admin.destinations.index')
                ->with('error', 'Error loading destination for edit: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified destination in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'address' => 'required|string',
                'category' => 'required|string',
                'coordinates' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $destination = destinations::findOrFail($id);
            
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'category' => $request->category,
                'coordinates' => $request->coordinates,
            ];

            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($destination->image && Storage::exists('public/destinations/' . $destination->image)) {
                    Storage::delete('public/destinations/' . $destination->image);
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/destinations', $imageName);
                $data['image'] = $imageName;
            }

            $destination->update($data);

            return redirect()->route('admin.destinations.index')
                ->with('success', 'Destination updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating destination: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating destination: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified destination from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $destination = destinations::findOrFail($id);
            
            // Delete image if exists
            if ($destination->image && Storage::exists('public/destinations/' . $destination->image)) {
                Storage::delete('public/destinations/' . $destination->image);
            }
            
            // Check if there are any dependencies before deleting
            $reviewsCount = reviews::where('destination_id', $id)->count();
            
            if ($reviewsCount > 0) {
                return redirect()->route('admin.destinations.index')
                    ->with('error', 'Cannot delete destination with reviews. Delete the associated reviews first.');
            }
            
            $destination->delete();

            return redirect()->route('admin.destinations.index')
                ->with('success', 'Destination deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting destination: ' . $e->getMessage());
            return redirect()->route('admin.destinations.index')
                ->with('error', 'Error deleting destination: ' . $e->getMessage());
        }
    }
}