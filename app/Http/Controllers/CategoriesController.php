<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\destinations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    // Public routes
    public function index()
    {
        $categories = categories::all();
        return view('guide.categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = categories::findOrFail($id);
        $destinations = destinations::where('category', $category->name)->get();
        return view('categories.show', compact('category', 'destinations'));
    }


    public function adminIndex()
    {
        $categories = categories::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        categories::create([
            'name' => $request->name,
        ]);

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
        } elseif (Auth::user()->role === 'guide') {
            return redirect()->route('guide.categories.index')->with('success', 'Category created successfully.');
        }
    }

    public function edit($id)
    {
        $category = categories::findOrFail($id);
        if (Auth::user()->role === 'admin') {
            return view('admin.categories.edit', compact('category'));
        } elseif (Auth::user()->role === 'guide') {
            return view('guide.categories.edit', compact('category'));
        }
    }

    public function update(Request $request, $id)
    {
        $category = categories::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
        } elseif (Auth::user()->role === 'guide') {
            return redirect()->route('guide.categories.index')->with('success', 'Category updated successfully.');
        }
    }

    public function destroy($id)
    {
        $category = categories::findOrFail($id);

        // Check if there are destinations using this category
        $destinationsCount = destinations::where('category', $category->name)->count();
        if ($destinationsCount > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category. It is being used by ' . $destinationsCount . ' destinations.');
        }

        $category->delete();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
        } elseif (Auth::user()->role === 'guide') {
            return redirect()->route('guide.categories.index')->with('success', 'Category deleted successfully.');
        }

    }
}
