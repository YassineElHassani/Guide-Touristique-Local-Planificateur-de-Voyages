@extends('admin.layout')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css">
    <style>
        .stat-card.blue {
            background-color: rgba(37, 99, 235, 0.1);
        }

        .stat-card.green {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .stat-card.purple {
            background-color: rgba(139, 92, 246, 0.1);
        }

        .stat-card.red {
            background-color: rgba(239, 68, 68, 0.1);
        }

        .stat-card.yellow {
            background-color: rgba(245, 158, 11, 0.1);
        }
    </style>
@endpush

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Stats Overview -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-card blue">
                        <div class="stat-icon" style="background-color: #2563eb;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-title">Total Users</div>
                        <div class="stat-value">{{ $stats['users'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-card green">
                        <div class="stat-icon" style="background-color: #10b981;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="stat-title">Destinations</div>
                        <div class="stat-value">{{ $stats['destinations'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-card purple">
                        <div class="stat-icon" style="background-color: #8b5cf6;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stat-title">Events</div>
                        <div class="stat-value">{{ $stats['events'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-card yellow">
                        <div class="stat-icon" style="background-color: #f59e0b;">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="stat-title">Reservations</div>
                        <div class="stat-value">{{ $stats['reservations'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-1">
        <!-- Chart Area -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Monthly Activity</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                            id="chartFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            This Year
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chartFilterDropdown">
                            <li><a class="dropdown-item active" href="#">This Year</a></li>
                            <li><a class="dropdown-item" href="#">Last Year</a></li>
                            <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="activityChart" height="83"></canvas>
                </div>
            </div>
        </div>

        <!-- Stats Table -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Active Users</td>
                                <td class="text-end fw-bold">{{ $stats['users'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>Guides</td>
                                <td class="text-end fw-bold">
                                    {{ $stats['guides'] ?? (App\Models\User::where('role', 'guide')->count() ?? 0) }}</td>
                            </tr>
                            <tr>
                                <td>Reviews</td>
                                <td class="text-end fw-bold">{{ $stats['reviews'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>Blog Posts</td>
                                <td class="text-end fw-bold">{{ $stats['blogs'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>Categories</td>
                                <td class="text-end fw-bold">
                                    {{ $stats['categories'] ?? (App\Models\categories::count() ?? 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue and Reservation Charts -->
    <div class="row g-4 mb-4">
        <!-- Monthly Revenue Chart -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Monthly Revenue</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="60"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Destinations by Category -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Destinations by Category</h5>
                </div>
                <div class="card-body">
                    <canvas id="destinationsByCategoryChart" height="140"></canvas>
                </div>
            </div>
        </div>

        <!-- Activities Summary -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Activity Comparison</h5>
                </div>
                <div class="card-body">
                    <canvas id="activityComparisonChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Users -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Users</h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @forelse($recentUsers as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $avatar = $user->picture
                                                        ? (Str::startsWith($user->picture, 'http')
                                                            ? $user->picture
                                                            : asset('storage/' . $user->picture))
                                                        : asset('/assets/images/default-avatar.png');
                                                @endphp
                                                <img src="{{ $avatar }}" alt="{{ $user->first_name }}"
                                                    class="rounded-circle me-2" width="32" height="32">
                                                <div>
                                                    <div class="fw-semibold">{{ $user->first_name }}
                                                        {{ $user->last_name }}</div>
                                                    <div class="small text-muted">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span
                                                class="badge {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'guide' ? 'bg-success' : 'bg-primary') }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">No recent users</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Destinations -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Destinations</h5>
                    <a href="{{ route('admin.destinations.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @forelse($recentDestinations as $destination)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-semibold">{{ $destination->name }}</div>
                                                    <div class="small text-muted">{{ $destination->category }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.destinations.edit', $destination->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">No recent destinations</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Events -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Events</h5>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @forelse($recentEvents as $event)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $event->image) }}"
                                                    alt="{{ $event->name }}" class="rounded me-2" width="32"
                                                    height="32" style="object-fit: cover;">
                                                <div>
                                                    <div class="fw-semibold">{{ $event->name }}</div>
                                                    <div class="small text-muted">
                                                        @if (isset($event->date))
                                                            {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                                        @else
                                                            No date
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.events.edit', $event->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">No recent events</td>
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
            // Get monthly data from PHP
            const monthlyData = @json($monthlyStats ?? []);

            // Monthly Activity Chart
            const activityCtx = document.getElementById('activityChart').getContext('2d');

            // Prepare datasets
            const usersData = [];
            const reservationsData = [];
            const eventsData = [];
            const destinationsData = [];

            // Ensure we have data for all 12 months
            for (let i = 1; i <= 12; i++) {
                usersData.push(monthlyData[i]?.users || 0);
                reservationsData.push(monthlyData[i]?.reservations || 0);
                eventsData.push(monthlyData[i]?.events || 0);
                destinationsData.push(monthlyData[i]?.destinations || 0);
            }

            const activityChart = new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                            label: 'Users',
                            data: usersData,
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2
                        },
                        {
                            label: 'Reservations',
                            data: reservationsData,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2
                        },
                        {
                            label: 'Events',
                            data: eventsData,
                            borderColor: '#8b5cf6',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2
                        },
                        {
                            label: 'Destinations',
                            data: destinationsData,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
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
                            position: 'top',
                            align: 'end'
                        },
                        tooltip: {
                            callbacks: {
                                title: function(tooltipItems) {
                                    return tooltipItems[0].label + ' Activity';
                                }
                            }
                        }
                    }
                }
            });
            
            // Monthly Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            
            // Extract revenue data
            const revenueData = [];
            for (let i = 1; i <= 12; i++) {
                revenueData.push(monthlyData[i]?.revenue || 0);
            }
            
            const revenueChart = new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue',
                        data: revenueData,
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderColor: '#10b981',
                        borderWidth: 1,
                        borderRadius: 4,
                        maxBarThickness: 35
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return '$' + context.raw;
                                }
                            }
                        }
                    }
                }
            });
            
            // Get destination categories from the controller
            const destinationCategories = @json($destinationCategories ?? []);
            
            const destinationsByCategoryCtx = document.getElementById('destinationsByCategoryChart').getContext('2d');
            
            const destinationsByCategoryChart = new Chart(destinationsByCategoryCtx, {
                type: 'bar',
                data: {
                    labels: destinationCategories.map(cat => cat[0]),
                    datasets: [{
                        label: 'Number of Destinations',
                        data: destinationCategories.map(cat => cat[1]),
                        backgroundColor: 'rgba(245, 158, 11, 0.8)',
                        borderColor: '#f59e0b',
                        borderWidth: 1,
                        borderRadius: 4,
                        maxBarThickness: 50
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Activity Comparison Chart - Comparing different platform activities
            const activityComparisonCtx = document.getElementById('activityComparisonChart').getContext('2d');
            
            const activityComparisonData = {
                labels: ['Reservations', 'Reviews', 'Blogs'],
                datasets: [{
                    label: 'Count',
                    data: [
                        {{ $stats['reservations'] ?? 0 }},
                        {{ $stats['reviews'] ?? 0 }},
                        {{ $stats['blogs'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(37, 99, 235, 0.8)'
                    ],
                    borderWidth: 0
                }]
            };
            
            const activityComparisonChart = new Chart(activityComparisonCtx, {
                type: 'polarArea',
                data: activityComparisonData,
                options: {
                    responsive: true,
                    scales: {
                        r: {
                            display: false
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush