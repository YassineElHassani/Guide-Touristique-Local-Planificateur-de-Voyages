@extends('guide.dashboard')

@section('dashboard-title', $destination->name)
@section('dashboard-breadcrumb', 'Destination Details')

@section('dashboard-actions')
    <div class="btn-group">
        <a href="{{ route('guide.destinations.edit', $destination->id) }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i> Edit Destination
        </a>
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteDestinationModal">
            <i class="fas fa-trash me-1"></i> Delete
        </button>
    </div>
@endsection

@section('dashboard-content')
    <!-- Delete Destination Modal -->
    <div class="modal fade" id="deleteDestinationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $destination->name }}</strong>?</p>
                    @php
                        $eventCount = \App\Models\events::where('user_id', Auth::id())
                            ->where('location', 'like', '%' . $destination->name . '%')
                            ->count();
                    @endphp
                    @if($eventCount > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            This destination is associated with {{ $eventCount }} events. Deleting it may affect those events.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('guide.destinations.destroy', $destination->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Destination</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Destination Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    @if($destination->image)
                        <img src="{{ asset('storage/' . $destination->image) }}" class="card-img-top" alt="{{ $destination->name }}" style="max-height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-map-marker-alt fa-4x text-secondary"></i>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="badge bg-primary rounded-pill me-2">Destination</span>
                                @if($destination->category)
                                    <span class="badge bg-secondary rounded-pill">{{ $destination->category->name }}</span>
                                @endif
                            </div>
                            <div>
                                <span class="badge {{ $destination->status == 'published' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($destination->status) }}
                                </span>
                                @if($destination->is_featured)
                                    <span class="badge bg-info ms-1">Featured</span>
                                @endif
                            </div>
                        </div>
                        
                        <h3 class="mb-3">{{ $destination->name }}</h3>
                        
                        <div class="d-flex align-items-center mb-4">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <span>{{ $destination->location }}</span>
                        </div>
                        
                        <h5 class="mb-3">Description</h5>
                        <p>{{ $destination->description }}</p>
                        
                        @if($destination->highlights)
                            <h5 class="mb-3 mt-4">Highlights</h5>
                            <p>{{ $destination->highlights }}</p>
                        @endif
                        
                        @if($destination->tips)
                            <h5 class="mb-3 mt-4">Travel Tips</h5>
                            <p>{{ $destination->tips }}</p>
                        @endif
                        
                        @if($destination->address || $destination->latitude || $destination->longitude)
                            <h5 class="mb-3 mt-4">Location Details</h5>
                            <div class="row">
                                @if($destination->address)
                                    <div class="col-md-12 mb-3">
                                        <strong>Address:</strong> {{ $destination->address }}
                                    </div>
                                @endif
                                
                                @if($destination->latitude && $destination->longitude)
                                    <div class="col-md-6">
                                        <strong>Latitude:</strong> {{ $destination->latitude }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Longitude:</strong> {{ $destination->longitude }}
                                    </div>
                                @endif
                            </div>
                        @endif
                        
                        @if($destination->best_time_to_visit || $destination->ideal_duration)
                            <h5 class="mb-3 mt-4">Visit Information</h5>
                            <div class="row">
                                @if($destination->best_time_to_visit)
                                    <div class="col-md-6 mb-2">
                                        <strong>Best Time to Visit:</strong> {{ $destination->best_time_to_visit }}
                                    </div>
                                @endif
                                
                                @if($destination->ideal_duration)
                                    <div class="col-md-6 mb-2">
                                        <strong>Ideal Duration:</strong> {{ $destination->ideal_duration }}
                                    </div>
                                @endif
                            </div>
                        @endif
                        
                        @if($destination->tags)
                            <h5 class="mb-3 mt-4">Tags</h5>
                            <div>
                                @foreach(explode(',', $destination->tags) as $tag)
                                    <span class="badge bg-light text-dark me-1 mb-1">{{ trim($tag) }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Gallery -->
            @if($destination->gallery)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Gallery</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach(json_decode($destination->gallery) as $image)
                                <div class="col-md-4">
                                    <a href="{{ asset('storage/' . $image) }}" data-lightbox="destination-gallery" data-title="{{ $destination->name }}">
                                        <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded" alt="{{ $destination->name }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Related Events -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Events at This Destination</h5>
                    <a href="{{ route('guide.events.create') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus me-1"></i> Create Event
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $relatedEvents = \App\Models\events::where('user_id', Auth::id())
                            ->where('location', 'like', '%' . $destination->name . '%')
                            ->orderBy('date', 'desc')
                            ->take(3)
                            ->get();
                    @endphp
                    
                    <div class="row g-4">
                        @forelse($relatedEvents as $event)
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100">
                                    @if($event->image)
                                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" height="140" style="object-fit: cover;" alt="{{ $event->name }}">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 140px;">
                                            <i class="fas fa-calendar-alt fa-2x text-secondary"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $event->name }}</h6>
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-calendar-day me-1"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                        </p>
                                        <p class="text-muted small mb-3">
                                            <i class="fas fa-dollar-sign me-1"></i> ${{ number_format($event->price, 2) }}
                                        </p>
                                        <a href="{{ route('guide.events.show', $event->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5>No Events Found</h5>
                                <p class="text-muted">You haven't created any events for this destination yet.</p>
                                <a href="{{ route('guide.events.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus me-1"></i> Create Event
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Destination Stats -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Destination Statistics</h5>
                </div>
                <div class="card-body">
                    @php
                        $totalEvents = \App\Models\events::where('user_id', Auth::id())
                            ->where('location', 'like', '%' . $destination->name . '%')
                            ->count();
                            
                        $eventIds = \App\Models\events::where('user_id', Auth::id())
                            ->where('location', 'like', '%' . $destination->name . '%')
                            ->pluck('id')
                            ->toArray();
                            
                        $totalReservations = \App\Models\reservations::whereIn('event_id', $eventIds)
                            ->count();
                            
                        $totalRevenue = \App\Models\reservations::whereIn('event_id', $eventIds)
                            ->where('status', 'confirmed')
                            ->sum('total_price');
                            
                        $avgRating = \App\Models\reviews::whereIn('event_id', $eventIds)
                            ->avg('rating') ?? 0;
                    @endphp
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $totalEvents }}</h6>
                                            <small class="text-muted">Events</small>
                                        </div>
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2">
                                            <i class="fas fa-calendar-alt text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $totalReservations }}</h6>
                                            <small class="text-muted">Reservations</small>
                                        </div>
                                        <div class="rounded-circle bg-success bg-opacity-10 p-2">
                                            <i class="fas fa-users text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">${{ number_format($totalRevenue, 0) }}</h6>
                                            <small class="text-muted">Revenue</small>
                                        </div>
                                        <div class="rounded-circle bg-warning bg-opacity-10 p-2">
                                            <i class="fas fa-dollar-sign text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ number_format($avgRating, 1) }}</h6>
                                            <small class="text-muted">Avg. Rating</small>
                                        </div>
                                        <div class="rounded-circle bg-info bg-opacity-10 p-2">
                                            <i class="fas fa-star text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($destination->created_at)
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between text-muted small">
                                <span>Created:</span>
                                <span>{{ \Carbon\Carbon::parse($destination->created_at)->format('M d, Y') }}</span>
                            </div>
                            @if($destination->updated_at && $destination->updated_at != $destination->created_at)
                                <div class="d-flex justify-content-between text-muted small mt-1">
                                    <span>Last Updated:</span>
                                    <span>{{ \Carbon\Carbon::parse($destination->updated_at)->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Weather Widget -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Weather Forecast</h5>
                </div>
                <div class="card-body">
                    <div id="weather-container" data-location="{{ $destination->location }}">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading weather data...</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('guide.events.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Create Event at This Destination
                        </a>
                        <a href="{{ route('guide.destinations.edit', $destination->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i> Edit Destination
                        </a>
                        <a href="{{ route('destinations.show', $destination->id) }}" class="btn btn-outline-secondary" target="_blank">
                            <i class="fas fa-eye me-2"></i> View Public Page
                        </a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteDestinationModal">
                            <i class="fas fa-trash me-2"></i> Delete Destination
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Weather functionality
        const weatherContainer = document.getElementById('weather-container');

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
                const conditions = ['Sunny', 'Partly Cloudy', 'Cloudy', 'Rainy'][Math.floor(Math.random() * 4)];
                const icon = {
                    'Sunny': 'sun',
                    'Partly Cloudy': 'cloud-sun',
                    'Cloudy': 'cloud',
                    'Rainy': 'cloud-rain'
                }[conditions];

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
    });
</script>
@endpush
