@extends('client.dashboard')

@section('title', 'My Itineraries')
@section('dashboard-title', 'My Itineraries')
@section('dashboard-breadcrumb', 'Itineraries')

@section('dashboard-actions')
<a href="{{ route('client.itineraries.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i> Create Itinerary
</a>
@endsection

@section('dashboard-content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(count($itineraries) > 0)
    <div class="row g-4">
        @foreach($itineraries as $itinerary)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">{{ $itinerary->name }}</h5>
                            <span class="badge bg-{{ $itinerary->start_date >= now() ? 'primary' : 'secondary' }} rounded-pill">
                                {{ $itinerary->start_date >= now() ? 'Upcoming' : 'Past' }}
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <p class="card-text mb-0">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                {{ \Carbon\Carbon::parse($itinerary->start_date)->format('M d, Y') }} - 
                                {{ \Carbon\Carbon::parse($itinerary->end_date)->format('M d, Y') }}
                            </p>
                            <p class="card-text text-muted">
                                <i class="fas fa-clock text-primary me-2"></i>
                                {{ \Carbon\Carbon::parse($itinerary->start_date)->diffInDays($itinerary->end_date) + 1 }} days
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Destinations</h6>
                            <div class="d-flex flex-wrap">
                                @foreach($itinerary->destinations->take(3) as $destination)
                                    <span class="badge bg-light text-dark me-1 mb-1">
                                        <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                        {{ $destination->name }}
                                    </span>
                                @endforeach
                                @if(count($itinerary->destinations) > 3)
                                    <span class="badge bg-light text-dark mb-1">
                                        +{{ count($itinerary->destinations) - 3 }} more
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between">
                        <div>
                            <a href="{{ route('client.itineraries.show', $itinerary->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fas fa-eye me-1"></i> View
                            </a>
                            <a href="{{ route('client.itineraries.edit', $itinerary->id) }}" class="btn btn-sm btn-outline-secondary me-1">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <form action="{{ route('client.itineraries.destroy', $itinerary->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this itinerary?')">
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="shareDropdown{{ $itinerary->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-share-alt me-1"></i> Share
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="shareDropdown{{ $itinerary->id }}">
                                <li><a class="dropdown-item" href="{{ route('client.itineraries.share', $itinerary->id) }}"><i class="fas fa-link me-2"></i> Get Link</a></li>
                                <li><a class="dropdown-item" href="{{ route('client.itineraries.generate-pdf', $itinerary->id) }}"><i class="fas fa-file-pdf me-2"></i> Export as PDF</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i> Email</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <div class="py-5">
            <i class="fas fa-route fa-4x text-muted mb-4"></i>
            <h3>No Itineraries Yet</h3>
            <p class="text-muted">Create your first travel itinerary to start planning your trips!</p>
            <a href="{{ route('client.itineraries.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i> Create Itinerary
            </a>
        </div>
    </div>
@endif

<!-- Creation Tips -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-body p-4">
        <h5 class="card-title">Tips for Creating Great Itineraries</h5>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="d-flex align-items-start mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; min-width: 32px;">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div>
                        <h6>Research Local Attractions</h6>
                        <p class="text-muted small mb-0">Explore popular destinations and hidden gems to include in your itinerary.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; min-width: 32px;">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div>
                        <h6>Plan Day by Day</h6>
                        <p class="text-muted small mb-0">Organize your activities by day to make the most of your time.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; min-width: 32px;">
                        <i class="fas fa-map"></i>
                    </div>
                    <div>
                        <h6>Consider Travel Time</h6>
                        <p class="text-muted small mb-0">Account for transportation between destinations in your schedule.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; min-width: 32px;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h6>Allow Free Time</h6>
                        <p class="text-muted small mb-0">Leave some room for spontaneous activities and relaxation.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection