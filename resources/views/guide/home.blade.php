@extends('guide.dashboard')

@section('dashboard-title', 'Welcome Back, ' . (Auth::user()->first_name ?? ''))

@section('dashboard-actions')
    <a href="{{ route('guide.events.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Create Event
    </a>
@endsection

@section('dashboard-content')
    @php
        // Get the authenticated user's events
        $userEvents = \App\Models\events::where('id', Auth::id())->pluck('id');
        
        // Get reservations for the user's events
        $eventReservations = \App\Models\reservations::whereIn('event_id', $userEvents)->get();
        $confirmedReservations = $eventReservations->where('status', 'confirmed');
        
        // Get reviews for the user's events
        $eventReviews = \App\Models\reviews::whereIn('event_id', $userEvents)->get();
        
        // Calculate total revenue
        $totalRevenue = 0;
        foreach ($confirmedReservations as $reservation) {
            $event = \App\Models\events::find($reservation->event_id);
            if ($event) {
                $totalRevenue += $event->price;
            }
        }
    @endphp

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-calendar-check text-info fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Reservations</h6>
                            <h3 class="mb-0">{{ $eventReservations->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('guide.reservations.index') }}" class="text-decoration-none small">View details <i
                            class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-check-circle text-success fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Confirmed Bookings</h6>
                            <h3 class="mb-0">{{ $confirmedReservations->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('guide.reservations.index', ['status' => 'confirmed']) }}"
                        class="text-decoration-none small">View details <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-star text-warning fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Reviews Received</h6>
                            <h3 class="mb-0">{{ $eventReviews->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('guide.reviews') }}" class="text-decoration-none small">View details <i
                            class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-dollar-sign text-danger fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Revenue</h6>
                            <h3 class="mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('guide.statistics') }}" class="text-decoration-none small">View statistics <i
                            class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Blogs Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">Latest Blog Posts</h5>
            <a href="{{ route('guide.blogs.index') }}" class="text-decoration-none small">View all</a>
        </div>
        <div class="card-body p-0">
            @php
                $latestBlogs = \App\Models\Blog::with('user')
                    ->published()
                    ->orderBy('created_at', 'desc')
                    ->take(4)
                    ->get();
            @endphp

            <div class="row g-0">
                @forelse($latestBlogs as $blog)
                    <div class="col-md-6 p-3 border-bottom @if($loop->iteration % 2 == 0) border-start @endif @if($loop->iteration > 2) border-top @endif">
                        <div class="d-flex h-100">
                            <div class="flex-shrink-0">
                                @if($blog->image)
                                    <img src="{{ asset('storage/' . $blog->image) }}" class="rounded" width="100" height="100" style="object-fit: cover;" alt="{{ $blog->title }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                        <i class="fas fa-newspaper fa-2x text-secondary"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-3 d-flex flex-column">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="badge bg-primary rounded-pill">{{ $blog->category }}</span>
                                        <small class="text-muted">{{ $blog->created_at->diffForHumans() }}</small>
                                    </div>
                                    <h5 class="card-title mb-1">{{ Str::limit($blog->title, 40) }}</h5>
                                    <p class="text-muted small mb-2">By {{ $blog->user->first_name }} {{ $blog->user->last_name }}</p>
                                </div>
                                <p class="card-text small text-muted mb-2">{{ Str::limit($blog->excerpt ?? strip_tags($blog->content), 80) }}</p>
                                <div class="mt-auto">
                                    <a href="{{ route('guide.blogs.show', $blog->id) }}" class="btn btn-sm btn-outline-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 p-5 text-center">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                            <h5>No Blog Posts Found</h5>
                            <p class="text-muted">There are no published blog posts yet.</p>
                            <a href="{{ route('guide.blogs.create') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus me-1"></i> Create a Blog Post
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Weather functionality
                const weatherContainer = document.getElementById('weather-container');
                const locationInput = document.getElementById('location-input');
                const checkWeatherBtn = document.getElementById('check-weather-btn');

                function loadWeather(location) {
                    if (!weatherContainer) return;

                    weatherContainer.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading weather data...</p>
                </div>
            `;

                    // Mock weather display (would be an API call in a real app)
                    setTimeout(() => {
                        const mockTemp = Math.floor(Math.random() * 15) + 15; // Random temp between 15-30°C
                        const conditions = ['Sunny', 'Partly Cloudy', 'Cloudy', 'Rainy'][Math.floor(Math
                            .random() * 4)];
                        const icon = {
                            'Sunny': 'sun',
                            'Partly Cloudy': 'cloud-sun',
                            'Cloudy': 'cloud',
                            'Rainy': 'cloud-rain'
                        } [conditions];

                        weatherContainer.innerHTML = `
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-${icon} fa-4x text-warning"></i>
                        </div>
                        <h2 class="mb-0">${mockTemp}°C</h2>
                        <p class="text-muted">${location} - ${conditions}</p>
                    </div>
                    
                    <div class="row g-2">
                        <div class="col-3">
                            <div class="text-center p-2 rounded bg-light">
                                <p class="small mb-1">Today</p>
                                <i class="fas fa-${icon} text-warning"></i>
                                <p class="mb-0">${mockTemp}°C</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-center p-2 rounded bg-light">
                                <p class="small mb-1">Tomorrow</p>
                                <i class="fas fa-${['sun', 'cloud-sun', 'cloud', 'cloud-rain'][Math.floor(Math.random() * 4)]} text-secondary"></i>
                                <p class="mb-0">${mockTemp + Math.floor(Math.random() * 5) - 2}°C</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-center p-2 rounded bg-light">
                                <p class="small mb-1">Day 3</p>
                                <i class="fas fa-${['sun', 'cloud-sun', 'cloud', 'cloud-rain'][Math.floor(Math.random() * 4)]} text-secondary"></i>
                                <p class="mb-0">${mockTemp + Math.floor(Math.random() * 5) - 2}°C</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-center p-2 rounded bg-light">
                                <p class="small mb-1">Day 4</p>
                                <i class="fas fa-${['sun', 'cloud-sun', 'cloud', 'cloud-rain'][Math.floor(Math.random() * 4)]} text-secondary"></i>
                                <p class="mb-0">${mockTemp + Math.floor(Math.random() * 5) - 2}°C</p>
                            </div>
                        </div>
                    </div>
                `;
                    }, 1000);
                }

                // Initial weather load
                if (weatherContainer) {
                    loadWeather(weatherContainer.dataset.location || 'Paris');
                }

                // Weather button click handler
                if (checkWeatherBtn && locationInput) {
                    checkWeatherBtn.addEventListener('click', function() {
                        const location = locationInput.value.trim();
                        if (location) {
                            loadWeather(location);
                        }
                    });

                    // Enter key in location input
                    locationInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            const location = this.value.trim();
                            if (location) {
                                loadWeather(location);
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
