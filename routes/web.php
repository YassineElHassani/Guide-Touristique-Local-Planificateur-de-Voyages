<?php

use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\ItinerariesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\WeatherForecastsController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BlogController;


// Authentication routes
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'signup'])->name('register.post');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'signin'])->name('login.post')->middleware(AuthMiddleware::class);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallBack']);

// Home navication routes/
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');

// Destination routes/
Route::get('/destinations', [DestinationsController::class, 'index'])->name('destinations.index');
Route::get('/destinations/category/{category}', [DestinationsController::class, 'byCategory'])->name('destinations.by-category');
Route::get('/destinations/{id}', [DestinationsController::class, 'show'])->name('destinations.show');
Route::get('/search/destinations', [DestinationsController::class, 'search'])->name('destinations.search');

// Event routes
Route::get('/events', [EventsController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventsController::class, 'show'])->name('events.show');
Route::get('/search/events', [EventsController::class, 'search'])->name('events.search');

// Category routes
Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoriesController::class, 'show'])->name('categories.show');

// Weather route
Route::get('/weather', [WeatherForecastsController::class, 'getWeather'])->name('weather.get');
Route::get('/weather/widget/{location}', [WeatherForecastsController::class, 'widget'])->name('weather.widget');

// Shared itinerary route
Route::get('/itineraries/shared/{token}', [ItinerariesController::class, 'showShared'])->name('shared.itinerary');

// Profile routes
Route::get('/profile', [ProfilesController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfilesController::class, 'update'])->name('profile.update');

// Review routes
Route::post('/reviews', [ReviewsController::class, 'store'])->name('reviews.store');
Route::put('/reviews/{id}', [ReviewsController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{id}', [ReviewsController::class, 'destroy'])->name('reviews.destroy');

// Blog routes
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/blogs/{slug}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
Route::put('/blogs/{slug}', [BlogController::class, 'update'])->name('blogs.update');
Route::delete('/blogs/{slug}', [BlogController::class, 'destroy'])->name('blogs.destroy');
Route::get('/blogs/category/{category}', [BlogController::class, 'byCategory'])->name('blogs.category');
Route::get('/search/blogs', [BlogController::class, 'search'])->name('blogs.search');
Route::post('/blogs/{slug}/comments', [BlogController::class, 'storeComment'])->name('blogs.comments.store');
Route::delete('/comments/{id}', [BlogController::class, 'destroyComment'])->name('blogs.comments.destroy');
Route::get('/my-blogs', [BlogController::class, 'myBlogs'])->name('blogs.my-blogs');

// Client/Traveler routes
Route::middleware(['client'])->prefix('client')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/home', [ClientController::class, 'home'])->name('client.home');

    // Profile routes
    Route::get('/profile', [ProfilesController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfilesController::class, 'update'])->name('profile.update');

    // Favorites routes
    Route::get('/favorites', [ClientController::class, 'favorites'])->name('client.favorites');
    Route::post('/favorites/add/{id}', [ClientController::class, 'addToFavorites'])->name('client.favorites.add');
    Route::delete('/favorites/remove/{id}', [ClientController::class, 'removeFromFavorites'])->name('client.favorites.remove');

    // Reservation routes
    Route::get('/reservations', [ClientController::class, 'reservations'])->name('client.reservations');
    Route::get('/reservations/{id}', [ClientController::class, 'showReservation'])->name('client.reservations.show');
    Route::put('/reservations/{id}/cancel', [ClientController::class, 'cancelReservation'])->name('client.reservations.cancel');
    Route::get('/events/{eventId}/book', [ReservationsController::class, 'create'])->name('client.reservations.create');
    Route::post('/events/{eventId}/book', [ReservationsController::class, 'store'])->name('client.reservations.store');

    // Review routes
    Route::get('/reviews', [ClientController::class, 'reviews'])->name('client.reviews');
    Route::get('/reviews/{id}/edit', [ClientController::class, 'editReview'])->name('client.reviews.edit');
    Route::put('/reviews/{id}', [ClientController::class, 'updateReview'])->name('client.reviews.update');
    Route::delete('/reviews/{id}', [ClientController::class, 'deleteReview'])->name('client.reviews.delete');

    // Itinerary routes
    Route::get('/itineraries', [ItinerariesController::class, 'index'])->name('client.itineraries.index');
    Route::get('/itineraries/create', [ItinerariesController::class, 'create'])->name('client.itineraries.create');
    Route::post('/itineraries', [ItinerariesController::class, 'store'])->name('client.itineraries.store');
    Route::get('/itineraries/{id}', [ItinerariesController::class, 'show'])->name('client.itineraries.show');
    Route::get('/itineraries/{id}/edit', [ItinerariesController::class, 'edit'])->name('client.itineraries.edit');
    Route::put('/itineraries/{id}', [ItinerariesController::class, 'update'])->name('client.itineraries.update');
    Route::delete('/itineraries/{id}', [ItinerariesController::class, 'destroy'])->name('client.itineraries.destroy');
    Route::get('/itineraries/{id}/share', [ItinerariesController::class, 'share'])->name('client.itineraries.share');
    Route::get('/itineraries/{id}/pdf', [ItinerariesController::class, 'generatePdf'])->name('client.itineraries.generate-pdf');
});

// Guide routes
Route::middleware(['guide'])->prefix('guide')->group(function () {
    Route::get('/dashboard', [GuideController::class, 'dashboard'])->name('guide.dashboard');

    // Profile routes
    Route::get('/profile', [ProfilesController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfilesController::class, 'update'])->name('profile.update');

    // Events management
    Route::get('/events', [GuideController::class, 'events'])->name('guide.events');
    Route::get('/events/create', [EventsController::class, 'create'])->name('guide.events.create');
    Route::post('/events', [EventsController::class, 'store'])->name('guide.events.store');
    Route::get('/events/{id}', [EventsController::class, 'show'])->name('guide.events.show');
    Route::get('/events/{id}/edit', [EventsController::class, 'edit'])->name('guide.events.edit');
    Route::put('/events/{id}', [EventsController::class, 'update'])->name('guide.events.update');
    Route::delete('/events/{id}', [EventsController::class, 'destroy'])->name('guide.events.destroy');

    // Reservations management
    Route::get('/reservations', [GuideController::class, 'reservations'])->name('guide.reservations');
    Route::get('/reservations/{id}', [GuideController::class, 'showReservation'])->name('guide.reservations.show');
    Route::put('/reservations/{id}/status', [GuideController::class, 'updateReservationStatus'])->name('guide.reservations.update-status');

    // Reviews
    Route::get('/reviews', [GuideController::class, 'reviews'])->name('guide.reviews');

    // Statistics
    Route::get('/statistics', [GuideController::class, 'statistics'])->name('guide.statistics');
});

// Admin routes
Route::middleware(['admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard.index');

    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::get('/users/{id}/profile', [AdminController::class, 'userProfile'])->name('users.profile');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::put('/users/{id}/status', [AdminController::class, 'updateUserStatus'])->name('admin.users.update-status');
    Route::put('/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.update-role');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.destroy');

    // Destination management
    Route::get('/destinations', [DestinationsController::class, 'adminIndex'])->name('admin.destinations.index');
    Route::get('/destinations/create', [DestinationsController::class, 'create'])->name('admin.destinations.create');
    Route::post('/destinations', [DestinationsController::class, 'store'])->name('admin.destinations.store');
    Route::get('/destinations/{id}', [DestinationsController::class, 'show'])->name('admin.destinations.show');
    Route::get('/destinations/{id}/edit', [DestinationsController::class, 'edit'])->name('admin.destinations.edit');
    Route::put('/destinations/{id}', [DestinationsController::class, 'update'])->name('admin.destinations.update');
    Route::delete('/destinations/{id}', [DestinationsController::class, 'destroy'])->name('admin.destinations.destroy');

    // Event management
    Route::get('/events', [EventsController::class, 'adminIndex'])->name('admin.events.index');
    Route::get('/events/create', [EventsController::class, 'create'])->name('admin.events.create');
    Route::post('/events', [EventsController::class, 'store'])->name('admin.events.store');
    Route::get('/events/{id}', [EventsController::class, 'adminShow'])->name('admin.events.show');
    Route::get('/events/{id}/edit', [EventsController::class, 'edit'])->name('admin.events.edit');
    Route::put('/events/{id}', [EventsController::class, 'update'])->name('admin.events.update');
    Route::delete('/events/{id}', [EventsController::class, 'destroy'])->name('admin.events.destroy');

    // Category management
    Route::get('/categories', [CategoriesController::class, 'adminIndex'])->name('admin.categories.index');
    Route::get('/categories/create', [CategoriesController::class, 'create'])->name('admin.categories.create');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/{id}', [CategoriesController::class, 'show'])->name('admin.categories.show');
    Route::get('/categories/{id}/edit', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/categories/{id}', [CategoriesController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');

    // Blog management
    Route::get('/blogs', [BlogController::class, 'adminIndex'])->name('admin.blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('admin.blogs.store');
    Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('admin.blogs.show');
    Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('/blogs/{id}', [BlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('admin.blogs.destroy');
    Route::patch('/blogs/{id}/toggle-featured', [BlogController::class, 'toggleFeatured'])->name('admin.blogs.toggle-featured');
    Route::patch('/blogs/{id}/status', [BlogController::class, 'updateStatus'])->name('admin.blogs.update-status');

    // Blog Comments management
    Route::get('/comments', [BlogController::class, 'adminComments'])->name('admin.comments.index');
    Route::get('/comments/{id}', [BlogController::class, 'showComment'])->name('admin.comments.show');
    Route::put('/comments/{id}', [BlogController::class, 'updateComment'])->name('admin.comments.update');
    Route::delete('/comments/{id}', [BlogController::class, 'destroyComment'])->name('admin.comments.destroy');

    // Review management
    Route::get('/reviews', [ReviewsController::class, 'adminIndex'])->name('admin.reviews.index');
    Route::get('/reviews/{id}', [ReviewsController::class, 'show'])->name('admin.reviews.show');
    Route::put('/reviews/{id}', [ReviewsController::class, 'update'])->name('admin.reviews.update');
    Route::delete('/reviews/{id}', [ReviewsController::class, 'destroy'])->name('admin.reviews.destroy');

    // Itinerary management
    Route::get('/itineraries', [ItinerariesController::class, 'adminIndex'])->name('admin.itineraries.index');
    Route::get('/itineraries/{id}', [ItinerariesController::class, 'show'])->name('admin.itineraries.show');
    Route::delete('/itineraries/{id}', [ItinerariesController::class, 'destroy'])->name('admin.itineraries.destroy');

    // Profile routes
    Route::get('/profile', [ProfilesController::class, 'show'])->name('admin.profile.index');
    Route::get('/profile/edit', [ProfilesController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/profile', [ProfilesController::class, 'update'])->name('admin.profile.update');

    // Reservation management
    Route::get('/reservations', [ReservationsController::class, 'adminIndex'])->name('admin.reservations.index');
    Route::get('/reservations/{id}', [ReservationsController::class, 'show'])->name('admin.reservations.show');
    Route::put('/reservations/{id}/status', [ReservationsController::class, 'updateStatus'])->name('admin.reservations.update-status');
    Route::delete('/reservations/{id}', [ReservationsController::class, 'destroy'])->name('admin.reservations.destroy');

    // Site settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings.index');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

    // Analytics
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics.index');

    // Export data
    Route::get('/export/{type?}', [AdminController::class, 'exportData'])->name('admin.export');

    // Activity logs
    Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('admin.activity-logs');

    // Global search
    Route::get('/search', [AdminController::class, 'search'])->name('admin.search');
});