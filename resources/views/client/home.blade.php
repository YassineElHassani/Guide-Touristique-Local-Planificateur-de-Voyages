@extends('client.dashboard')

@section('dashboard-title', 'Welcome Back, ' . (Auth::user()->first_name ?? ''))

@section('dashboard-actions')
    <a href="{{ route('client.events.index') }}" class="btn btn-primary">
        <i class="fas fa-compass me-1"></i> Explore Events
    </a>
@endsection

@section('dashboard-content')
    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-calendar-check text-warning fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Reservations</h6>
                            <h3 class="mb-0">{{ $reservations->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('client.reservations.index') }}" class="text-decoration-none small">View all <i
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
                            <h6 class="text-muted mb-1">Confirmed</h6>
                            <h3 class="mb-0">{{ $reservations->where('status', 'confirmed')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('client.reservations.index') }}" class="text-decoration-none small">View all <i
                            class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-heart text-danger fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Favorites</h6>
                            <h3 class="mb-0">{{ $favorites->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('client.favorites') }}" class="text-decoration-none small">View all <i
                            class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-star text-info fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Reviews</h6>
                            <h3 class="mb-0">{{ $reviews->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('client.reviews') }}" class="text-decoration-none small">View all <i
                            class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Trips Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">Your Upcoming Trips</h5>
            <a href="{{ route('client.reservations.index') }}" class="text-decoration-none small">View all</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Event</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations->where('date', '>=', now())->sortBy('date')->take(3) as $reservation)
                            <tr id="reservation-row-{{ $reservation->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($reservation->event && $reservation->event->image)
                                            <img src="{{ asset('storage/' . $reservation->event->image) }}"
                                                class="rounded me-2" width="50" height="50"
                                                alt="{{ $reservation->event->name }}">
                                        @else
                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-calendar-alt text-secondary"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $reservation->event->name ?? 'Unknown Event' }}</h6>
                                            <small class="text-muted">Price:
                                                ${{ number_format($reservation->event->price ?? 0, 2) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $reservation->event->location ?? 'Unknown Location' }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</td>
                                <td>
                                    @php
                                        $statusClass = 'secondary';

                                        if ($reservation->status == 'pending') {
                                            $statusClass = 'warning';
                                        } elseif ($reservation->status == 'confirmed') {
                                            $statusClass = 'success';
                                        } elseif ($reservation->status == 'cancelled') {
                                            $statusClass = 'danger';
                                        }
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ ucfirst($reservation->status) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('client.reservations.show', $reservation->id) }}"
                                        class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye"></i></a>
                                    @if ($reservation->status != 'cancelled')
                                        <form action="{{ route('client.reservations.cancel', $reservation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                                        <h5>No Upcoming Trips</h5>
                                        <p class="text-muted">You don't have any upcoming reservations.</p>
                                        <a href="{{ route('client.events.index') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-search"></i> Explore Events
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recommendations and Weather Row -->
    <div class="row g-4">
        <!-- Recommended Tours -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">Recommended Events</h5>
                    <a href="{{ route('client.events.index') }}" class="text-decoration-none small">View more</a>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @php
                            $recommendedEvents = \App\Models\events::where('date', '>=', now())
                                ->orderBy('date', 'asc')
                                ->take(2)
                                ->get();
                        @endphp

                        @forelse($recommendedEvents as $event)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    @if ($event->image)
                                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top"
                                            height="160" style="object-fit: cover;" alt="{{ $event->name }}">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                            style="height: 160px;">
                                            <i class="fas fa-calendar-alt fa-3x text-secondary"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="badge bg-primary rounded-pill">Event</span>
                                            <span
                                                class="text-primary fw-bold">${{ number_format($event->price, 2) }}</span>
                                        </div>
                                        <h5 class="card-title mb-1">{{ $event->name }}</h5>
                                        <p class="text-muted small mb-3"><i
                                                class="fas fa-map-marker-alt me-1"></i>{{ $event->location }}</p>
                                        <p class="text-muted small mb-3"><i
                                                class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ route('client.events.show', $event->id) }}"
                                                class="btn btn-sm btn-outline-primary">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4">
                                <i class="fas fa-calendar fa-3x text-muted mb-3"></i>
                                <h5>No Recommended Events</h5>
                                <p class="text-muted">We don't have any recommended events at this time.</p>
                                <a href="{{ route('client.events.index') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-search"></i> Browse All Events
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Weather Widget -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Weather Forecast</h5>
                </div>
                <div class="card-body">
                    @php
                        $defaultLocation = 'Paris';
                        if ($reservations->where('date', '>=', now())->count() > 0) {
                            $nextTrip = $reservations->where('date', '>=', now())->sortBy('date')->first();
                            if ($nextTrip && $nextTrip->event) {
                                $defaultLocation = $nextTrip->event->location;
                            }
                        }
                    @endphp

                    <div id="weather-container" data-location="{{ $defaultLocation }}">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading weather data...</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="mb-3">Check weather for your trip:</h6>
                        <div class="input-group">
                            <input type="text" id="location-input" class="form-control" placeholder="Enter location"
                                value="{{ $defaultLocation }}">
                            <button class="btn btn-primary" type="button" id="check-weather-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Your Recent Favorites -->
    <div class="card border-0 shadow-sm my-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">Your Favorite Destinations</h5>
            <a href="{{ route('client.favorites') }}" class="text-decoration-none small">View all</a>
        </div>
        <div class="card-body">
            <div class="row g-4">
                @forelse($favorites->take(3) as $favorite)
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="position-relative">
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 160px;">
                                    <i class="fas fa-map-marker-alt fa-3x text-secondary"></i>
                                </div>
                                <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                    data-bs-toggle="modal" data-bs-target="#removeFavoriteModal{{ $favorite->id }}">
                                    <i class="fas fa-heart-broken"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $favorite->name }}</h5>
                                <p class="card-text text-muted small">{{ $favorite->address }}</p>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($favorite->description, 100) }}</p>
                                <a href="{{ route('client.destinations.show', $favorite->id) }}"
                                    class="btn btn-sm btn-outline-primary">View Details</a>
                            </div>

                            <!-- Remove Favorite Modal -->
                            <div class="modal fade" id="removeFavoriteModal{{ $favorite->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Remove from Favorites</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to remove <strong>{{ $favorite->name }}</strong> from
                                                your favorites?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('client.favorites.remove', $favorite->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Remove</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                        <h5>No Favorite Destinations</h5>
                        <p class="text-muted">You haven't added any destinations to your favorites yet.</p>
                        <a href="{{ route('destinations.index') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-search"></i> Explore Destinations
                        </a>
                    </div>
                @endforelse
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
