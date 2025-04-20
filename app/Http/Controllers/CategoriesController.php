<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\destinations;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = categories::all();
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = categories::findOrFail($id);
        $destinations = destinations::where('category', $category->name)->get();
        return view('categories.show', compact('category', 'destinations'));
    }

    // Admin methods below - protected by middleware in routes

    public function adminIndex()
    {
        $categories = categories::all();
        return view('admin.categories', compact('categories'));
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

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = categories::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
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

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
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

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}