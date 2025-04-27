@extends('guide.dashboard')

@section('dashboard-title', 'All Events')

@section('dashboard-actions')
    <div class="btn-group">
        <a href="{{ route('guide.events.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> My Events
        </a>
        <a href="{{ route('guide.events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Create Event
        </a>
    </div>
@endsection

@section('dashboard-content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">Browse All Events</h5>
            <span class="badge bg-primary rounded-pill">{{ $events->total() ?? count($events) }} Events</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Guide</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;" alt="{{ $event->name }}">
                                        @else
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-calendar-alt text-secondary"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $event->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                <td>{{ $event->location }}</td>
                                <td>${{ number_format($event->price, 2) }}</td>
                                <td>
                                    @php
                                        $guide = \App\Models\User::find($event->id);
                                    @endphp
                                    @if($guide)
                                        <span class="badge bg-light text-dark">
                                            {{ $guide->first_name }} {{ $guide->last_name }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Unknown</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('guide.events.show', $event->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($event->user_id == Auth::id())
                                            <a href="{{ route('guide.events.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h5>No Events Found</h5>
                                        <p class="text-muted">No events match your search criteria.</p>
                                        <a href="{{ route('guide.events.all') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-sync me-1"></i> Reset Filters
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($events->count() > 0 && method_exists($events, 'links'))
            <div class="card-footer bg-white border-0 py-3">
                {{ $events->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <!-- Popular Events -->
    @if($events->count() > 0)
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Popular Upcoming Events</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    @php
                        $popularEvents = \App\Models\events::where('date', '>=', now())
                            ->orderBy('date', 'asc')
                            ->take(3)
                            ->get();
                    @endphp
                    
                    @foreach($popularEvents as $event)
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" height="160" style="object-fit: cover;" alt="{{ $event->name }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 160px;">
                                        <i class="fas fa-calendar-alt fa-3x text-secondary"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge bg-primary rounded-pill">Event</span>
                                        <span class="text-primary fw-bold">${{ number_format($event->price, 2) }}</span>
                                    </div>
                                    <h5 class="card-title mb-1">{{ $event->name }}</h5>
                                    <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt me-1"></i>{{ $event->location }}</p>
                                    <p class="text-muted small mb-3"><i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('guide.events.show', $event->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                        @php
                                            $guide = \App\Models\User::find($event->user_id);
                                        @endphp
                                        @if($guide)
                                            <small class="text-muted">By {{ $guide->first_name }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection