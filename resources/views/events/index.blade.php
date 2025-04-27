@extends('layouts.template')

@section('title', 'Upcoming Events')

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="fw-bold mb-3">Explore Local Events</h1>
                    <p class="lead mb-0">Discover unique experiences and adventures led by passionate local guides.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Search & Filter -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <form action="{{ route('events.search') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" class="form-control" name="query"
                                            placeholder="Search events..." value="{{ request('query') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="date" class="form-control" name="date"
                                            value="{{ request('date') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-filter me-2"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Events Grid -->
                <h2 class="fw-bold mb-4">{{ request('query') || request('date') ? 'Search Results' : 'Upcoming Events' }}
                </h2>

                {{-- <div class="row g-4 mb-5">
                    @forelse($events as $event)
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                @if ($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top"
                                        alt="{{ $event->name }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                        style="height: 200px;">
                                        <i class="fas fa-calendar-alt fa-3x text-secondary"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-primary">{{ $event->category ?? 'Event' }}</span>
                                        <span class="badge bg-secondary">${{ number_format($event->price, 2) }}</span>
                                    </div>
                                    <h5 class="card-title mb-2">{{ $event->name }}</h5>
                                    <p class="card-text text-muted small mb-2">
                                        <i class="fas fa-map-marker-alt me-1"></i> {{ $event->location }}
                                    </p>
                                    <p class="card-text text-muted small mb-3">
                                        <i class="fas fa-calendar-day me-1"></i>
                                        {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                        @if ($event->time)
                                            <i class="fas fa-clock ms-2 me-1"></i>
                                            {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                                        @endif
                                    </p>
                                    <p class="card-text mb-4">{{ Str::limit($event->description, 100) }}</p>

                                    @php
                                        $reservationsCount = \App\Models\reservations::where('event_id', $event->id)
                                            ->where('status', 'confirmed')
                                            ->count();
                                        $availableSpots = $event->capacity - $reservationsCount;
                                    @endphp

                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $availableSpots }} of {{ $event->capacity ?? 20 }} spots left
                                            </small>

                                            @if (\Carbon\Carbon::parse($event->date)->isPast())
                                                <span class="badge bg-danger">Ended</span>
                                            @elseif($availableSpots <= 0)
                                                <span class="badge bg-warning">Sold Out</span>
                                            @elseif(\Carbon\Carbon::parse($event->date)->isToday())
                                                <span class="badge bg-success">Today</span>
                                            @endif
                                        </div>

                                        <a href="{{ route('events.show', $event->id) }}"
                                            class="btn btn-outline-primary w-100">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-calendar-times fa-4x text-muted mb-4"></i>
                            <h3>No Events Found</h3>
                            <p class="text-muted">We couldn't find any events matching your criteria. Try adjusting your
                                search or check back later.</p>
                        </div>
                    @endforelse
                </div> --}}

                <!-- Events Grid -->
                <div class="row g-4">
                    @forelse($events as $event)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm hover-shadow">
                                <div class="position-relative">
                                    @if ($event->image)
                                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top"
                                            alt="{{ $event->name }}" style="height: 180px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex justify-content-center align-items-center"
                                            style="height: 180px;">
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
                                        <a href="{{ route('events.show', $event->id) }}"
                                            class="btn btn-outline-primary">
                                            <i class="fas fa-info-circle me-1"></i> Details
                                        </a>
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
                                <a href="{{ route('events.index') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-sync me-1"></i> Reset Filters
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($events->count() > 0 && method_exists($events, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $events->appends(request()->query())->links() }}
                    </div>
                @endif

            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">


                <!-- Popular Locations -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0">Popular Locations</h4>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $locations = \App\Models\events::select('location')
                                ->distinct()
                                ->whereNotNull('location')
                                ->take(10)
                                ->pluck('location');
                        @endphp

                        <div class="list-group list-group-flush">
                            @foreach ($locations as $location)
                                <a href="{{ route('events.search', ['location' => $location]) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0">
                                    <span><i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        {{ $location }}</span>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ \App\Models\events::where('location', $location)->count() }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Become a Guide -->
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-tie fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-3">Become a Local Guide</h4>
                        <p class="mb-4">Share your knowledge and passion for your city by hosting events and earning
                            money.</p>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Get Started <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-4">Ready for Your Next Adventure?</h2>
                    <p class="lead mb-4">Join our community of travelers and discover unique local experiences around the
                        world.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-user-plus me-2"></i> Sign Up
                        </a>
                        <a href="{{ route('destinations.index') }}" class="btn btn-outline-primary btn-lg px-4">
                            <i class="fas fa-map-marked-alt me-2"></i> Explore Destinations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
