@extends('layouts.template')

@section('title', 'Book Event')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/app/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .event-image {
            height: 300px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .detail-card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .detail-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }

        .detail-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 50%;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .form-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush

@section('content')
    <div class="container py-5">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="dashboard-sidebar p-4">
                    <!-- User Info -->
                    <div class="d-flex align-items-center mb-4">
                        @php
                            $avatar = Auth::user()->picture
                                ? (Str::startsWith(Auth::user()->picture, 'http')
                                    ? Auth::user()->picture
                                    : asset('storage/' . Auth::user()->picture))
                                : asset('/assets/images/default-avatar.png');
                        @endphp
                        <img src="{{ $avatar }}" alt="{{ Auth::user()->first_name }}" class="user-avatar me-3">
                        <div>
                            <h5 class="mb-1">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
                            <p class="text-muted mb-0 small">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Main</h6>

                        <a href="{{ route('client.home') }}"
                            class="sidebar-link {{ request()->routeIs('client.home') ? 'active' : '' }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>

                        <a href="{{ route('client.blogs.index') }}"
                            class="sidebar-link {{ request()->routeIs('client.blogs.*') ? 'active' : '' }}">
                            <i class="fas fa-blog"></i> Blogs
                        </a>

                        <a href="{{ route('client.events.index') }}"
                            class="sidebar-link {{ request()->routeIs('client.events.*') ? 'active' : '' }}">
                            <i class="fas fa-ticket-alt"></i> Events
                        </a>

                        <a href="{{ route('client.reservations.index') }}"
                            class="sidebar-link {{ request()->routeIs('client.reservations*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check"></i> Reservations
                        </a>

                        <a href="{{ route('client.favorites') }}"
                            class="sidebar-link {{ request()->routeIs('client.favorites*') ? 'active' : '' }}">
                            <i class="fas fa-heart"></i> Favorites
                        </a>

                        <a href="{{ route('client.reviews') }}"
                            class="sidebar-link {{ request()->routeIs('client.reviews*') ? 'active' : '' }}">
                            <i class="fas fa-star"></i> Reviews
                        </a>
                    </div>

                    <div class="sidebar-divider"></div>

                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Account</h6>

                        <a href="{{ route('client.profile.show') }}"
                            class="sidebar-link {{ request()->routeIs('client.profile*') ? 'active' : '' }}">
                            <i class="fas fa-user"></i> Profile
                        </a>

                        <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Header -->
                <div class="dashboard-header mb-4 p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-1">Book Event</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('client.reservations.index') }}">Reservations</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Book Event</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <strong>Error!</strong> Please check the form for errors.
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <!-- Event Details -->
                    <div class="col-md-7">
                        <div class="card detail-card">
                            @if ($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="event-image card-img-top"
                                    alt="{{ $event->name }}">
                            @else
                                <div
                                    class="event-image card-img-top bg-light d-flex justify-content-center align-items-center">
                                    <i class="fas fa-calendar-day fa-5x text-muted"></i>
                                </div>
                            @endif

                            <div class="card-body">
                                <h4 class="card-title mb-4">{{ $event->name }}</h4>

                                <ul class="list-unstyled detail-list">
                                    <li>
                                        <div class="detail-icon">
                                            <i class="fas fa-map-marker-alt text-danger"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Location</small>
                                            <span class="fw-medium">{{ $event->location }}</span>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="detail-icon">
                                            <i class="far fa-calendar-alt text-primary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Event Date</small>
                                            <span class="fw-medium">{{ $event->date->format('F d, Y') }}</span>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="detail-icon">
                                            <i class="fas fa-money-bill-wave text-success"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Price</small>
                                            <span class="fw-medium">${{ number_format($event->price, 2) }}</span>
                                        </div>
                                    </li>
                                </ul>

                                <h5 class="mt-4 mb-3">Description</h5>
                                <p>{{ $event->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <div class="col-md-5">
                        <div class="form-card p-4">
                            <h4 class="mb-4">Book This Event</h4>

                            <form action="{{ route('client.reservations.store', $event->id) }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label for="date" class="form-label">Select Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        <input type="text"
                                            class="form-control date-picker @error('date') is-invalid @enderror"
                                            id="date" name="date" placeholder="Choose a date"
                                            value="{{ old('date', $event->date->format('Y-m-d')) }}" required>
                                    </div>
                                    @error('date')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">The event is scheduled for
                                        {{ $event->date->format('F d, Y') }}</small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Booking Summary</label>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Event:</span>
                                                <span class="fw-medium">{{ $event->name }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Price:</span>
                                                <span class="fw-medium">${{ number_format($event->price, 2) }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>Date:</span>
                                                <span class="fw-medium"
                                                    id="selectedDateDisplay">{{ $event->date->format('M d, Y') }}</span>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between fw-bold">
                                                <span>Total:</span>
                                                <span>${{ number_format($event->price, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="{{ route('terms') }}" target="_blank">terms and
                                            conditions</a>
                                    </label>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-calendar-check me-2"></i> Book Now
                                    </button>
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize date picker
            const datePicker = flatpickr("#date", {
                minDate: "today",
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr) {
                    // Update the displayed date in the summary
                    const date = new Date(dateStr);
                    const options = {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    };
                    document.getElementById('selectedDateDisplay').textContent = date
                        .toLocaleDateString('en-US', options);
                }
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                if (!document.getElementById('terms').checked) {
                    event.preventDefault();
                    alert('Please agree to the terms and conditions to proceed.');
                }
            });
        });
    </script>
@endpush
