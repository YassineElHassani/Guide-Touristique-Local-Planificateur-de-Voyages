@extends('admin.layout')

@section('title', 'Analytics')
@section('heading', 'Analytics Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Analytics</li>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Overview</h5>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="periodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Last 12 Months
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="periodDropdown">
                            <li><a class="dropdown-item active" href="#">Last 12 Months</a></li>
                            <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                            <li><a class="dropdown-item" href="#">Last Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="mb-3">Monthly Trends</h6>
                            <canvas id="monthlySummaryChart" height="250"></canvas>
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-3">User Distribution</h6>
                            <canvas id="userDistributionChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Destinations by Category</h5>
                </div>
                <div class="card-body">
                    <canvas id="destinationsByCategoryChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Top Rated Destinations</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Destination</th>
                                    <th>Rating</th>
                                    <th>Reviews</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topRatedDestinations as $destination)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.destinations.show', $destination->id) }}">
                                                {{ $destination->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="text-warning me-2">
                                                    {{ number_format($destination->average_rating, 1) }}
                                                </div>
                                                <div class="progress flex-grow-1" style="height: 6px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" 
                                                        style="width: {{ ($destination->average_rating / 5) * 100 }}%" 
                                                        aria-valuenow="{{ $destination->average_rating }}" 
                                                        aria-valuemin="0" aria-valuemax="5">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $destination->review_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3">No rated destinations yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Registration Trend</h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary active">Monthly</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Weekly</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Daily</button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="userRegistrationChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Most Active Users</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Activity Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mostActiveUsers as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $user->avatar ?? 'https://via.placeholder.com/32' }}" 
                                                    class="rounded-circle me-2" width="32" height="32" alt="{{ $user->name }}">
                                                <div>
                                                    <div class="fw-semibold">{{ $user->name }}</div>
                                                    <div class="small text-muted">
                                                        <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'guide' ? 'bg-success' : 'bg-primary') }}">
                                                            {{ ucfirst($user->role ?? 'N/A') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="fw-semibold">{{ $user->reservation_count + $user->review_count + $user->itinerary_count }}</div>
                                                <div class="small text-muted">
                                                    {{ $user->reservation_count }} reservations, 
                                                    {{ $user->review_count }} reviews, 
                                                    {{ $user->itinerary_count }} itineraries
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-3">No active users data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Summary Chart
        const monthlySummaryCtx = document.getElementById('monthlySummaryChart').getContext('2d');
        
        // Prepare data from PHP
        @php
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $monthlyReservationsData = array_fill(0, 12, 0);
            $monthlyRevenueData = array_fill(0, 12, 0);
            
            foreach ($monthlyReservations as $item) {
                $monthlyReservationsData[$item->month - 1] = $item->count;
            }
            
            foreach ($revenueByMonth as $item) {
                $monthlyRevenueData[$item->month - 1] = $item->total;
            }
        @endphp
        
        new Chart(monthlySummaryCtx, {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [
                    {
                        label: 'Reservations',
                        data: @json($monthlyReservationsData),
                        backgroundColor: 'rgba(37, 99, 235, 0.7)',
                        borderColor: 'rgba(37, 99, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Revenue',
                        type: 'line',
                        data: @json($monthlyRevenueData),
                        borderColor: 'rgba(16, 185, 129, 1)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
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
                        },
                        grid: {
                            drawBorder: false
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Revenue ($)'
                        },
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end'
                    }
                }
            }
        });
        
        // User Distribution Chart
        const userDistributionCtx = document.getElementById('userDistributionChart').getContext('2d');
        
        @php
            $userRoleCounts = [
                'Admin' => \App\Models\User::where('role', 'admin')->count(),
                'Guide' => \App\Models\User::where('role', 'guide')->count(),
                'Traveler' => \App\Models\User::where('role', 'travler')->count(),
            ];
        @endphp
        
        new Chart(userDistributionCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(@json($userRoleCounts)),
                datasets: [{
                    data: Object.values(@json($userRoleCounts)),
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(37, 99, 235, 0.7)'
                    ],
                    borderColor: [
                        'rgba(239, 68, 68, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(37, 99, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
        
        // Destinations by Category Chart
        const destinationsByCategoryCtx = document.getElementById('destinationsByCategoryChart').getContext('2d');
        
        @php
            $categoryNames = [];
            $categoryCounts = [];
            
            foreach ($destinationsByCategory as $category) {
                $categoryNames[] = $category->category;
                $categoryCounts[] = $category->count;
            }
        @endphp
        
        new Chart(destinationsByCategoryCtx, {
            type: 'bar',
            data: {
                labels: @json($categoryNames),
                datasets: [{
                    label: 'Number of Destinations',
                    data: @json($categoryCounts),
                    backgroundColor: 'rgba(139, 92, 246, 0.7)',
                    borderColor: 'rgba(139, 92, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        
        // User Registration Chart
        const userRegistrationCtx = document.getElementById('userRegistrationChart').getContext('2d');
        
        @php
            $registrationMonths = [];
            $registrationCounts = [];
            
            foreach ($userRegistrationTrend as $trend) {
                $registrationMonths[] = date('M Y', mktime(0, 0, 0, $trend->month, 1, $trend->year));
                $registrationCounts[] = $trend->count;
            }
        @endphp
        
        new Chart(userRegistrationCtx, {
            type: 'line',
            data: {
                labels: @json($registrationMonths),
                datasets: [{
                    label: 'New Users',
                    data: @json($registrationCounts),
                    borderColor: 'rgba(37, 99, 235, 1)',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endpush