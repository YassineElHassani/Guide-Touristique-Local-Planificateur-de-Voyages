@extends('guide.dashboard')

@section('dashboard-title', 'Reservations')

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
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search by client name, email or event name...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option value="">All Events</option>
                    {{-- @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                    @endforeach --}}
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary w-100">Apply Filters</button>
            </div>
        </div>
    </div>
</div>

<!-- Reservations Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Client</th>
                        <th>Event</th>
                        <th>Date & Time</th>
                        <th>Guests</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $reservation->user->avatar ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" class="rounded-circle me-3" width="40" height="40" alt="{{ $reservation->user->name ?? 'Client' }}">
                                    <div>
                                        <h6 class="mb-0">{{ $reservation->user->name ?? 'Client' }}</h6>
                                        <small class="text-muted">{{ $reservation->user->email ?? 'email@example.com' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $reservation->event->name ?? 'Event Name' }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}<br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($reservation->time)->format('h:i A') }}</small>
                            </td>
                            <td>{{ $reservation->guests ?? 1 }}</td>
                            <td>${{ number_format($reservation->total ?? 0, 2) }}</td>
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
                                <div class="btn-group">
                                    <a href="{{ route('guide.reservations.show', $reservation->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('guide.reservations.update-status', $reservation->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="fas fa-check me-2"></i> Confirm
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('guide.reservations.update-status', $reservation->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-times me-2"></i> Cancel
                                                </button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i> Contact Client</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="py-5">
                                    <i class="fas fa-calendar-check fa-4x text-muted mb-4"></i>
                                    <h4>No reservations yet</h4>
                                    <p class="text-muted mb-4">You don't have any reservations for your events yet.</p>
                                    {{-- <a href="{{ route('guide.events.index') }}" class="btn btn-primary">
                                        <i class="fas fa-calendar-alt me-1"></i> Manage Events
                                    </a> --}}
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
                <span class="text-muted">Showing {{ count($reservations) }} of {{ count($reservations) }} reservations</span>
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

<!-- Reservation Statistics -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Reservation Statistics</h5>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center">
                    <h2 class="fw-bold mb-1">{{ count($reservations) }}</h2>
                    <p class="text-muted">Total Reservations</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <h2 class="fw-bold mb-1">{{ $reservations->where('status', 'confirmed')->count() }}</h2>
                    <p class="text-muted">Confirmed</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <h2 class="fw-bold mb-1">{{ $reservations->where('status', 'pending')->count() }}</h2>
                    <p class="text-muted">Pending</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <h2 class="fw-bold mb-1">${{ number_format($reservations->sum('total') ?? 0, 2) }}</h2>
                    <p class="text-muted">Total Revenue</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Reservations Calendar -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Upcoming Reservations</h5>
    </div>
    <div class="card-body p-4">
        <div id="calendar"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        
        if (calendarEl) {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: [
                    // You would dynamically generate this from your reservations data
                    @foreach($reservations->where('status', '!=', 'cancelled') as $reservation)
                    {
                        title: '{{ $reservation->user->name ?? "Client" }} - {{ $reservation->event->name ?? "Event" }}',
                        start: '{{ $reservation->date }}T{{ $reservation->time }}',
                        url: '{{ route("guide.reservations.show", $reservation->id) }}',
                        backgroundColor: '{{ $reservation->status == "confirmed" ? "#1d8f3a" : "#f7931e" }}',
                        borderColor: '{{ $reservation->status == "confirmed" ? "#1d8f3a" : "#f7931e" }}'
                    },
                    @endforeach
                ],
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.location.href = info.event.url;
                    }
                }
            });
            
            calendar.render();
        }
    });
</script>
@endpush