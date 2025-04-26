@extends('client.dashboard')

@section('title', 'Browse Events')

@section('dashboard-title', 'Events & Activities')

@section('dashboard-content')
<!-- Header with navigation tabs -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">All Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('client.reservations.index') }}">My Reservations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('client.favorites') }}">My Favorites</a>
            </li>
        </ul>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Events Grid -->
<div class="row g-4">
    @forelse($events as $event)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm hover-shadow">
                <div class="position-relative">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->name }}" 
                             style="height: 180px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex justify-content-center align-items-center" style="height: 180px;">
                            <i class="fas fa-calendar-alt fa-3x text-secondary"></i>
                        </div>
                    @endif
                    <div class="position-absolute bottom-0 end-0 p-2">
                        <span class="badge bg-primary">${{ number_format($event->price, 2) }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $event->name }}</h5>
                    <div class="d-flex align-items-center text-muted mb-3">
                        <div class="me-3">
                            <i class="far fa-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                        </div>
                        <div>
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $event->location }}
                        </div>
                    </div>
                    <p class="card-text text-muted">
                        {{ Str::limit($event->description, 100) }}
                    </p>
                </div>
                <div class="card-footer bg-white border-0 pt-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('client.events.show', $event->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-info-circle me-1"></i> Details
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('client.reservations.create', $event->id) }}" class="btn btn-success">
                                <i class="fas fa-ticket-alt me-1"></i> Book
                            </a>
                            <form action="{{ route('client.favorites.add', $event->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-warning">
                                    <i class="far fa-heart"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="py-5">
                <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
                <h3>No Events Found</h3>
                <p class="text-muted">We couldn't find any events matching your criteria.</p>
                <a href="{{ route('client.events.index') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-sync me-1"></i> Reset Filters
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($events->count() > 0 && method_exists($events, 'links'))
    <div class="d-flex justify-content-center mt-4">
        {{ $events->appends(request()->query())->links() }}
    </div>
@endif

<!-- Popular Locations Section -->
<div class="mt-5">
    <h4 class="mb-3">Popular Event Locations</h4>
    <div class="row g-3">
        @php
            $destinations = App\Models\destinations::take(4)->get();
        @endphp
        
        @foreach($destinations as $destination)
            <div class="col-md-3">
                <div class="card bg-dark text-white hover-zoom d-flex justify-content-between align-items-end">
                    <img src="{{ asset('assets/images/destination.png') }}" 
                         class="card-img" alt="{{ $destination->name }}" 
                         style="height: 100px; width: 100px; opacity: 0.9;">
                    <div class="card-img-overlay d-flex align-items-end">
                        <div>
                            <h5 class="card-title mb-0 text-white">{{ $destination->name }}</h5>
                            <p class="card-text small">
                                @php
                                    $eventCount = App\Models\events::where('location', $destination->name)->count();
                                @endphp
                                {{ $eventCount }} {{ Str::plural('event', $eventCount) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection