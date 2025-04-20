@extends('guide.dashboard')

@section('dashboard-title', 'My Events')

@section('dashboard-actions')
<a href="{{ route('guide.events.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i> Create Event
</a>
@endsection

@section('dashboard-content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Filter and Search -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search events...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option value="">All Status</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary w-100">Apply Filters</button>
            </div>
        </div>
    </div>
</div>

<!-- Events Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Event</th>
                        <th>Date & Time</th>
                        <th>Capacity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $event->image_url ?? 'https://via.placeholder.com/50x50' }}" class="rounded me-3" width="50" height="50" alt="{{ $event->name }}">
                                    <div>
                                        <h6 class="mb-0">{{ $event->name }}</h6>
                                        <small class="text-muted">{{ $event->location }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}<br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <span class="badge bg-{{ ($event->reservations_count ?? 0) >= $event->capacity ? 'danger' : 'info' }} rounded-pill">
                                            {{ $event->reservations_count ?? 0 }} / {{ $event->capacity }}
                                        </span>
                                    </div>
                                    <div class="progress flex-grow-1" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($event->reservations_count ?? 0) / $event->capacity * 100 }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>${{ number_format($event->price, 2) }}</td>
                            <td>
                                @php
                                    $statusClass = 'secondary';
                                    if ($event->date >= now()) {
                                        $statusClass = 'success';
                                        $status = 'Upcoming';
                                    } else {
                                        $status = 'Completed';
                                    }
                                    
                                    if ($event->cancelled ?? false) {
                                        $statusClass = 'danger';
                                        $status = 'Cancelled';
                                    }
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">{{ $status }}</span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('guide.events.show', $event->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('guide.events.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteEventModal{{ $event->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteEventModal{{ $event->id }}" tabindex="-1" aria-labelledby="deleteEventModalLabel{{ $event->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteEventModalLabel{{ $event->id }}">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete the event "{{ $event->name }}"?</p>
                                                <p class="text-danger">This action cannot be undone.</p>
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
                            <td colspan="6" class="text-center py-4">
                                <div class="py-5">
                                    <i class="fas fa-calendar-alt fa-4x text-muted mb-4"></i>
                                    <h4>No events found</h4>
                                    <p class="text-muted mb-4">You haven't created any events yet.</p>
                                    <a href="{{ route('guide.events.create') }}" class="btn btn-primary">
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
    <div class="card-footer bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="text-muted">Showing {{ count($events) }} of {{ count($events) }} events</span>
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Event Statistics -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Event Statistics</h5>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center">
                    <h2 class="fw-bold mb-1">{{ count($events) }}</h2>
                    <p class="text-muted">Total Events</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <h2 class="fw-bold mb-1">{{ $events->where('date', '>=', now())->count() }}</h2>
                    <p class="text-muted">Upcoming</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <h2 class="fw-bold mb-1">{{ $events->sum('reservations_count') ?? 0 }}</h2>
                    <p class="text-muted">Reservations</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <h2 class="fw-bold mb-1">${{ number_format($events->sum('price'), 2) }}</h2>
                    <p class="text-muted">Revenue</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection