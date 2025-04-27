<?php

namespace App\Http\Controllers;

use App\Models\destinations;
use App\Models\events;
use App\Models\categories;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index()
    {
        // Get featured destinations
        $featuredDestinations = destinations::take(6)->get();
        
        // Get upcoming events
        $upcomingEvents = events::where('date', '>=', now())->orderBy('date', 'asc')->take(4)->get();
        
        // Get all categories
        $categories = categories::all();
        
        return view('welcome', compact('featuredDestinations', 'upcomingEvents', 'categories'));
    }

    /**
     * Show the about page.
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Show the contact page.
     */
    public function contact()
    {
        return view('contact');
    }

    public function warning()
    {
        return view('warning');
    }

    /**
     * Handle contact form submission.
     */
    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        // Here you would typically send an email or store the contact form data
        // For now, we'll just redirect with a success message
        
        return redirect()->route('contact')->with('success', 'Thank you for your message. We will get back to you soon!');
    }

    /**
     * Show the frequently asked questions page.
     */
    public function faq()
    {
        return view('faq');
    }

    /**
     * Show the terms and conditions page.
     */
    public function terms()
    {
        return view('terms');
    }

    /**
     * Show the privacy policy page.
     */
    public function privacy()
    {
        return view('privacy');
    }
}