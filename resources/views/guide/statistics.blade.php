@extends('guide.dashboard')

@section('dashboard-title', 'Performance Statistics')
@section('dashboard-breadcrumb', 'Statistics')

@section('dashboard-content')
    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-calendar-alt text-primary fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Events</h6>
                            @php
                                $totalEvents = \App\Models\events::where('user_id', Auth::id())->count();
                            @endphp
                            <h3 class="mb-0">{{ $totalEvents }}</h3>
                        </div>
                    </div>
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
                            <h6 class="text-muted mb-1">Total Reservations</h6>
                            @php
                                $eventIds = \App\Models\events::where('user_id', Auth::id())->pluck('id')->toArray();
                                $totalReservations = \App\Models\reservations::whereIn('event_id', $eventIds)->count();
                            @endphp
                            <h3 class="mb-0">{{ $totalReservations }}</h3>
                        </div>
                    </div>
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
                            <h6 class="text-muted mb-1">Average Rating</h6>
                            @php
                                $avgRating = \App\Models\reviews::whereIn('event_id', $eventIds)->avg('rating') ?? 0;
                            @endphp
                            <h3 class="mb-0">{{ number_format($avgRating, 1) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-dollar-sign text-warning fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Revenue</h6>
                            @php
                                $totalRevenue = \App\Models\reservations::whereIn('event_id', $eventIds)
                                    ->where('status', 'confirmed')
                                    ->sum('total_price');
                            @endphp
                            <h3 class="mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Monthly Reservations Chart -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Monthly Reservations</h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyReservationsChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Events -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Top Events by Reservations</h5>
                </div>
                <div class="card-body">
                    @php
                        $topEvents = \App\Models\events::where('user_id', Auth::id())
                            ->withCount(['reservations' => function($query) {
                                $query->where('status', '!=', 'cancelled');
                            }])
                            ->orderBy('reservations_count', 'desc')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @forelse($topEvents as $event)
                        <div class="d-flex align-items-center mb-3">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;" alt="{{ $event->name }}">
                            @else
                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-calendar-alt text-secondary"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $event->name }}</h6>
                                <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $event->reservations_count }} bookings</span>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="mb-0">No events with reservations yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Event Ratings -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Event Ratings</h5>
                </div>
                <div class="card-body">
                    <canvas id="eventRatingsChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Revenue Breakdown -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Revenue Breakdown</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Reservations Chart
        const monthlyReservationsCtx = document.getElementById('monthlyReservationsChart').getContext('2d');
        
        // Convert PHP data to JavaScript
        const monthlyReservationsData = @json($monthlyReservations);
        
        // Prepare data for chart
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const reservationCounts = Array(12).fill(0);
        
        monthlyReservationsData.forEach(item => {
            reservationCounts[item.month - 1] = item.count;
        });
        
        new Chart(monthlyReservationsCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Reservations',
                    data: reservationCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        // Event Ratings Chart
        const eventRatingsCtx = document.getElementById('eventRatingsChart').getContext('2d');
        
        // Convert PHP data to JavaScript
        const eventRatingsData = @json($eventRatings);
        
        // Prepare data for chart
        const eventNames = eventRatingsData.map(item => item.name);
        const avgRatings = eventRatingsData.map(item => item.average_rating || 0);
        const reviewCounts = eventRatingsData.map(item => item.review_count || 0);
        
        new Chart(eventRatingsCtx, {
            type: 'bar',
            data: {
                labels: eventNames,
                datasets: [{
                    label: 'Average Rating',
                    data: avgRatings,
                    backgroundColor: 'rgba(255, 193, 7, 0.5)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
                }, {
                    label: 'Number of Reviews',
                    data: reviewCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    type: 'line',
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5,
                        title: {
                            display: true,
                            text: 'Average Rating'
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: 'Number of Reviews'
                        },
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        
        // Convert PHP data to JavaScript
        const eventPopularityData = @json($eventPopularity);
        
        // Prepare data for chart
        const eventLabels = eventPopularityData.map(item => item.name);
        const reservationCounts2 = eventPopularityData.map(item => item.reservation_count);
        
        new Chart(revenueCtx, {
            type: 'pie',
            data: {
                labels: eventLabels,
                datasets: [{
                    data: reservationCounts2,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(199, 199, 199, 0.7)',
                        'rgba(83, 102, 255, 0.7)',
                        'rgba(40, 159, 64, 0.7)',
                        'rgba(210, 199, 199, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(199, 199, 199, 1)',
                        'rgba(83, 102, 255, 1)',
                        'rgba(40, 159, 64, 1)',
                        'rgba(210, 199, 199, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    title: {
                        display: true,
                        text: 'Reservation Distribution by Event'
                    }
                }
            }
        });
    });
</script>
@endpush
