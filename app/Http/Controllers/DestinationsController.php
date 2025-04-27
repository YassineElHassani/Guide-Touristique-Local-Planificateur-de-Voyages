<?php

namespace App\Http\Controllers;

use App\Models\destinations;
use App\Models\categories;
use App\Models\reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class DestinationsController extends Controller
{
    public function index()
    {
        $destinations = destinations::all();
        $categories = categories::all();
        return view('destinations.index', compact('destinations', 'categories'));
    }

    public function indexGuide() 
    {
        try {
            $destinations = destinations::all();
            return view('guide.destinations.index', compact('destinations'));
        } catch (\Exception $e) {
            Log::error('Error loading destinations: ' . $e->getMessage());
            return redirect()->route('guide.dashboard.index')
                ->with('error', 'Error loading destinations: ' . $e->getMessage());
        }
    }

    public function byCategory($category)
    {
        $destinations = destinations::where('category', $category)->get();
        $categoryObj = categories::where('name', $category)->first();
        return view('destinations.by_category', compact('destinations', 'categoryObj'));
    }

    public function show($id)
    {
        $destination = destinations::findOrFail($id);
        $reviews = reviews::where('destination_id', $id)->get();
        if (Auth::user()->role === 'guide') {
            return view('guide.destinations.show', compact('destination', 'reviews'));
        } elseif (Auth::user()->role === 'admin') {
            return view('admin.destinations.show', compact('destination', 'reviews'));
        } elseif (Auth::user()->role === 'travler') {
            return view('client.destinations.show', compact('destination', 'reviews'));
        }
    }

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

    public function adminIndex()
    {
        try {
            $destinations = destinations::all();
            return view('admin.destinations.index', compact('destinations'));
        } catch (\Exception $e) {
            Log::error('Error loading destinations: ' . $e->getMessage());
            return redirect()->route('admin.dashboard.index')
                ->with('error', 'Error loading destinations: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $categories = categories::all();
            if (Auth::user()->role === 'guide') {
                return view('guide.destinations.create', compact('categories'));
            } elseif (Auth::user()->role === 'admin') {
                return view('admin.destinations.create', compact('categories'));
            }
        } catch (\Exception $e) {
            Log::error('Error loading categories: ' . $e->getMessage());
            return redirect()->route('admin.destinations.index')
                ->with('error', 'Error loading categories: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'address' => 'required|string',
                'category' => 'required|string',
                'coordinates' => 'required|string',
            ]);

            destinations::create([
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'category' => $request->category,
                'coordinates' => $request->coordinates,
            ]);

            if (Auth::user()->role === 'guide') {
                return redirect()->route('guide.destinations.index')
                    ->with('success', 'Destination created successfully.');
            } elseif (Auth::user()->role === 'admin') {
                return redirect()->route('admin.destinations.index')
                    ->with('success', 'Destination created successfully.');
            }

        } catch (\Exception $e) {
            Log::error('Error creating destination: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating destination: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $destination = destinations::findOrFail($id);
            $categories = categories::all();

            if (Auth::user()->role === 'guide') {
                return view('guide.destinations.edit', compact('destination', 'categories'));
            } elseif (Auth::user()->role === 'admin') {
                return view('admin.destinations.edit', compact('destination', 'categories'));
            }

        } catch (\Exception $e) {
            Log::error('Error loading destination for edit: ' . $e->getMessage());
            return redirect()->route('admin.destinations.index')
                ->with('error', 'Error loading destination for edit: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'address' => 'required|string',
                'category' => 'required|string',
                'coordinates' => 'required|string',
            ]);

            $destination = destinations::findOrFail($id);

            $destination->update([
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'category' => $request->category,
                'coordinates' => $request->coordinates,
            ]);

            if (Auth::user()->role === 'guide') {
                return redirect()->route('guide.destinations.index')
                    ->with('success', 'Destination updated successfully.');
            } elseif (Auth::user()->role === 'admin') {
                return redirect()->route('admin.destinations.index')
                    ->with('success', 'Destination updated successfully.');
            }

        } catch (\Exception $e) {
            Log::error('Error updating destination: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating destination: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $destination = destinations::findOrFail($id);

            $reviewsCount = reviews::where('destination_id', $id)->count();

            if ($reviewsCount > 0) {
                return redirect()->route('admin.destinations.index')
                    ->with('error', 'Cannot delete destination with reviews. Delete the associated reviews first.');
            }

            $destination->delete();

            if (Auth::user()->role === 'guide') {
                return redirect()->route('guide.destinations.index')
                    ->with('success', 'Destination deleted successfully.');
            } elseif (Auth::user()->role === 'admin') {
                return redirect()->route('admin.destinations.index')
                    ->with('success', 'Destination deleted successfully.');
            }

        } catch (\Exception $e) {
            Log::error('Error deleting destination: ' . $e->getMessage());
            return redirect()->route('admin.destinations.index')
                ->with('error', 'Error deleting destination: ' . $e->getMessage());
        }
    }
}