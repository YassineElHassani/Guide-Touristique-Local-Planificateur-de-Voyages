@extends('layouts.template')

@section('title', 'Reservation Details')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/app/css/dashboard.css') }}">
    <style>
        .status-badge {
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .event-image {
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }

        .detail-card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .timeline-item {
            position: relative;
            padding-left: 40px;
            margin-bottom: 20px;
        }

        .timeline-item:before {
            content: "";
            position: absolute;
            left: 10px;
            top: 0;
            bottom: -20px;
            width: 2px;
            background-color: #e9ecef;
        }

        .timeline-item:last-child:before {
            bottom: 0;
        }

        .timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #fff;
            border: 2px solid #6c757d;
            z-index: 1;
        }

        .timeline-icon.confirmed {
            border-color: #28a745;
        }

        .timeline-icon.cancelled {
            border-color: #dc3545;
        }

        .timeline-icon.pending {
            border-color: #ffc107;
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
                            <h3 class="mb-1">Reservation Details</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('client.reservations.index') }}">Reservations</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <span class="status-badge status-{{ $reservation->status }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Reservation Details -->
                <div class="row g-4">
                    <!-- Event Information -->
                    <div class="col-md-7">
                        <div class="card detail-card h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Event Information</h5>

                                @if ($reservation->event)
                                    @if ($reservation->event->image)
                                        <img src="{{ asset('storage/' . $reservation->event->image) }}"
                                            class="event-image w-100 mb-4" alt="{{ $reservation->event->name }}">
                                    @else
                                        <div
                                            class="event-image w-100 mb-4 bg-light d-flex justify-content-center align-items-center">
                                            <i class="fas fa-calendar-day fa-5x text-muted"></i>
                                        </div>
                                    @endif

                                    <h4 class="mb-3">{{ $reservation->event->name }}</h4>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-2 me-3">
                                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Location</small>
                                                    <span>{{ $reservation->event->location }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-2 me-3">
                                                    <i class="fas fa-money-bill-wave text-success"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Price</small>
                                                    <span>${{ number_format($reservation->event->price, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-2 me-3">
                                                    <i class="far fa-calendar-alt text-primary"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Event Date</small>
                                                    <span>{{ $reservation->date->format('F d, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-2 me-3">
                                                    <i class="fas fa-user-clock text-info"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Reserved On</small>
                                                    <span>{{ $reservation->created_at->format('F d, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="mt-4 mb-3">Description</h5>
                                    <p>{{ $reservation->event->description }}</p>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                                        <h5>Event Information Unavailable</h5>
                                        <p class="text-muted">The event details for this reservation are no longer
                                            available.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Reservation Status and Actions -->
                    <div class="col-md-5">
                        <div class="card detail-card mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Reservation Status</h5>

                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-icon {{ $reservation->created_at ? 'confirmed' : '' }}">
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">Reservation Created</h6>
                                            <p class="text-muted small mb-0">
                                                {{ $reservation->created_at ? $reservation->created_at->format('F d, Y - h:i A') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="timeline-item">
                                        <div
                                            class="timeline-icon {{ $reservation->status == 'confirmed' ? 'confirmed' : 'pending' }}">
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">
                                                @if ($reservation->status == 'confirmed')
                                                    Reservation Confirmed
                                                @elseif($reservation->status == 'cancelled')
                                                    Reservation Not Confirmed
                                                @else
                                                    Waiting for Confirmation
                                                @endif
                                            </h6>
                                            <p class="text-muted small mb-0">
                                                @if ($reservation->status == 'confirmed')
                                                    Your reservation has been confirmed
                                                @elseif($reservation->status == 'cancelled')
                                                    Reservation was not confirmed
                                                @else
                                                    The guide will confirm your reservation soon
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="timeline-item">
                                        <div
                                            class="timeline-icon {{ $reservation->status == 'cancelled' ? 'cancelled' : 'pending' }}">
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">
                                                @if ($reservation->status == 'cancelled')
                                                    Reservation Cancelled
                                                @else
                                                    Reservation Active
                                                @endif
                                            </h6>
                                            <p class="text-muted small mb-0">
                                                @if ($reservation->status == 'cancelled')
                                                    This reservation has been cancelled
                                                @else
                                                    Your reservation is currently active
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card detail-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Actions</h5>

                                <div class="d-grid gap-2">
                                    @if ($reservation->event)
                                        <a href="{{ route('client.events.show', $reservation->event->id) }}"
                                            class="btn btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-2"></i> View Event Page
                                        </a>
                                    @endif

                                    @if ($reservation->status === 'pending' || $reservation->status === 'confirmed')
                                        <form action="{{ route('client.reservations.cancel', $reservation->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger w-100 cancel-reservation-btn">
                                                <i class="fas fa-times-circle me-2"></i> Cancel Reservation
                                            </button>
                                        </form>
                                    @endif

                                    @if ($reservation->status === 'confirmed' && $reservation->event && $reservation->date >= now())
                                        <a href="#" class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#contactGuideModal">
                                            <i class="fas fa-comment-alt me-2"></i> Contact Guide
                                        </a>
                                    @endif

                                    <a href="{{ route('client.reservations.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i> Back to Reservations
                                    </a>
                                </div>
                            </div>
                        </div>

                        @if ($reservation->status === 'confirmed' && $reservation->event && $reservation->date < now())
                            <div class="card detail-card mt-4">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Rate Your Experience</h5>
                                    <p class="text-muted small mb-3">Share your thoughts about this event to help other
                                        travelers.</p>

                                    <a href="{{ route('client.reviews.create', ['event_id' => $reservation->event->id]) }}"
                                        class="btn btn-success w-100">
                                        <i class="fas fa-star me-2"></i> Write a Review
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Guide Modal -->
    <div class="modal fade" id="contactGuideModal" tabindex="-1" aria-labelledby="contactGuideModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactGuideModalLabel">Contact Guide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="contactForm">
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" placeholder="Enter subject">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Type your message here..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send Message</button>
                </div>
            </div>
        </div>
    </div>
@endsection
