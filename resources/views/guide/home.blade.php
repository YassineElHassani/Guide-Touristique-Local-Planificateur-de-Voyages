@extends('guide.dashboard')

@section('dashboard-title', 'Guide Dashboard')

@section('dashboard-actions')
<a href="{{ route('guide.events.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-1"></i> Create Event
</a>
@endsection

@section('dashboard-content')
<!-- Stats Overview -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-calendar-check text-primary fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Events</h6>
                        <h3 class="mb-0">{{ $stats['totalEvents'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="{{ route('guide.events') }}" class="text-decoration-none small">View all <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-users text-success fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Reservations</h6>
                        <h3 class="mb-0">{{ $stats['totalReservations'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="{{ route('guide.reservations') }}" class="text-decoration-none small">View all <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-calendar-alt text-info fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Upcoming</h6>
                        <h3 class="mb-0">{{ $stats['upcomingEvents'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="{{ route('guide.events') }}" class="text-decoration-none small">View all <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-wallet text-warning fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Revenue</h6>
                        <h3 class="mb-0">${{ number_format($stats['totalRevenue'], 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="#" class="text-decoration-none small">View details <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Events and Reservations -->
<div class="row g-4 mb-4">
    <!-- Upcoming Events -->
    <div class="col-md-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Upcoming Events</h5>
                <a href="{{ route('guide.events') }}" class="text-decoration-none small">View all</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Event</th>
                                <th>Date</th>
                                <th>Bookings</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events->where('date', '>=', now())->take(5) as $event)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $event->image_url ?? 'https://via.placeholder.com/50x50' }}" width="40" height="40" class="rounded me-2" alt="{{ $event->name }}">
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
                                        <span class="badge bg-info rounded-pill">{{ $event->reservations_count ?? 0 }} / {{ $event->capacity }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Confirmed</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3">No upcoming events.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Reservations -->
    <div class="col-md-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Recent Reservations</h5>
                <a href="{{ route('guide.reservations') }}" class="text-decoration-none small">View all</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentReservations as $reservation)
                        <a href="{{ route('guide.reservations.show', $reservation->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $reservation->user->avatar ?? 'https://via.placeholder.com/40x40' }}" width="40" height="40" class="rounded-circle me-3" alt="User">
                                    <div>
                                        <h6 class="mb-0">{{ $reservation->user->name ?? 'Guest' }}</h6>
                                        <small class="text-muted">{{ $reservation->event->name ?? 'Event' }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $reservation->status == 'confirmed' ? 'success' : ($reservation->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                    <div class="small text-muted mt-1">{{ $reservation->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="list-group-item text-center py-3">No recent reservations.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Performance Chart and Reviews -->
<div class="row g-4">
    <!-- Performance Chart -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Monthly Performance</h5>
            </div>
            <div class="card-body">
                <canvas id="performanceChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Latest Reviews -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Latest Reviews</h5>
                <a href="{{ route('guide.reviews') }}" class="text-decoration-none small">View all</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @for($i = 0; $i < 3; $i++)
                        <div class="list-group-item">
                            <div class="d-flex align-items-start">
                                <img src="https://randomuser.me/api/portraits/{{ ['men', 'women'][rand(0, 1)] }}/{{ rand(1, 99) }}.jpg" width="40" height="40" class="rounded-circle me-3" alt="Reviewer">
                                <div>
                                    <div class="mb-1">
                                        @for($j = 0; $j < 5; $j++)
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor
                                    </div>
                                    <p class="mb-1">Great experience with this guide! Very informative and friendly.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">John Doe</small>
                                        <small class="text-muted">2 days ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sample data for the performance chart
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'Reservations',
                        data: [12, 19, 15, 25, 22, 30],
                        backgroundColor: 'rgba(37, 99, 235, 0.7)',
                        borderColor: 'rgba(37, 99, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Revenue ($)',
                        data: [1200, 1900, 1500, 2500, 2200, 3000],
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Reservations'
                        }
                    },
                    y1: {
                        position: 'right',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue ($)'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
    });
</script>
@endpush