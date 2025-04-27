@extends('guide.dashboard')

@section('dashboard-title', 'Manage Events')
@section('dashboard-breadcrumb', 'Events')

@section('dashboard-actions')
    <div class="btn-group">
        <a href="{{ route('guide.events.all') }}" class="btn btn-outline-primary">
            <i class="fas fa-globe me-1"></i> View All Events
        </a>
        <a href="{{ route('guide.events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Create New Event
        </a>
    </div>
@endsection

@section('dashboard-content')
    <!-- Events List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Your Events</h5>
            <span class="badge bg-primary rounded-pill">{{ $events->total() ?? count($events) }} Events</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Price</th>
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
                                            <span class="text-muted small">{{ Str::limit($event->description, 50) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                <td>{{ $event->location }}</td>
                                <td>${{ number_format($event->price, 2) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('guide.events.show', $event->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('guide.events.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $event->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $event->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete <strong>{{ $event->name }}</strong>?</p>
                                                    <p class="text-danger">This action cannot be undone and will remove all reservations for this event.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('guide.events.destroy', $event->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete Event</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h5>No Events Found</h5>
                                        <p class="text-muted">You haven't created any events yet.</p>
                                        <a href="{{ route('guide.events.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus me-1"></i> Create Your First Event
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

    <!-- Event Statistics -->
    @if($events->count() > 0)
        <div class="row g-4 mt-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Upcoming Events</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $upcomingEvents = $events->where('date', '>=', now())->take(3);
                        @endphp
                        
                        @if($upcomingEvents->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($upcomingEvents as $event)
                                    <a href="{{ route('guide.events.show', $event->id) }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $event->name }}</h6>
                                            <small>{{ \Carbon\Carbon::parse($event->date)->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1 small text-muted">{{ $event->location }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small>${{ number_format($event->price, 2) }}</small>
                                            @php
                                                $reservationsCount = \App\Models\reservations::where('event_id', $event->id)->count();
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-secondary">{{ $reservationsCount }} reservations</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('guide.events.index') }}?date_from={{ date('Y-m-d') }}" class="btn btn-sm btn-outline-primary">View All Upcoming</a>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-day fa-3x text-muted mb-3"></i>
                                <h5>No Upcoming Events</h5>
                                <p class="text-muted">You don't have any events scheduled in the future.</p>
                                <a href="{{ route('guide.events.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus me-1"></i> Create New Event
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Event Overview</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $totalEvents = $events->count();
                            $upcomingCount = $events->where('date', '>=', now())->count();
                            $pastCount = $events->where('date', '<', now())->count();
                            
                            $eventReservations = \App\Models\reservations::whereIn('event_id', $events->pluck('id'))->get();
                            $confirmedReservations = $eventReservations->where('status', 'confirmed')->count();
                            $pendingReservations = $eventReservations->where('status', 'pending')->count();
                            $totalRevenue = $eventReservations->where('status', 'confirmed')->sum('total_price');
                        @endphp
                        
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $totalEvents }}</h6>
                                            <small class="text-muted">Total Events</small>
                                        </div>
                                        <div class="bg-info bg-opacity-10 p-2 rounded-circle">
                                            <i class="fas fa-calendar-alt text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $upcomingCount }}</h6>
                                            <small class="text-muted">Upcoming</small>
                                        </div>
                                        <div class="bg-success bg-opacity-10 p-2 rounded-circle">
                                            <i class="fas fa-calendar-day text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $eventReservations->count() }}</h6>
                                            <small class="text-muted">Reservations</small>
                                        </div>
                                        <div class="bg-secondary bg-opacity-10 p-2 rounded-circle">
                                            <i class="fas fa-calendar-check text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">${{ number_format($totalRevenue, 2) }}</h6>
                                            <small class="text-muted">Revenue</small>
                                        </div>
                                        <div class="bg-warning bg-opacity-10 p-2 rounded-circle">
                                            <i class="fas fa-dollar-sign text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h6 class="mb-3">Quick Actions</h6>
                            <div class="d-grid gap-2">
                                <a href="{{ route('guide.events.create') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-plus me-2"></i> Create New Event
                                </a>
                                <a href="{{ route('guide.reservations.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-calendar-check me-2"></i> Manage Reservations
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
