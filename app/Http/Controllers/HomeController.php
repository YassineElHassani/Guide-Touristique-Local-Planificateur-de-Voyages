<?php

namespace App\Http\Controllers;

use App\Models\destinations;
use App\Models\events;
use App\Models\categories;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredDestinations = destinations::take(6)->get();
        
        $upcomingEvents = events::where('date', '>=', now())->orderBy('date', 'asc')->take(4)->get();
        
        $categories = categories::all();
        
        return view('welcome', compact('featuredDestinations', 'upcomingEvents', 'categories'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function warning()
    {
        return view('warning');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        return redirect()->route('contact')->with('success', 'Thank you for your message. We will get back to you soon!');
    }

    public function terms()
    {
        return view('terms');
    }
    
    public function privacy()
    {
        return view('privacy');
    }
}