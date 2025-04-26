@extends('layouts.template')

@section('title', 'My Reservations')

@push('styles')
<link rel="stylesheet" href="{{ asset('/app/css/dashboard.css') }}">
<style>
    .reservation-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .reservation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .status-badge {
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 20px;
    }
    .event-image {
        height: 160px;
        object-fit: cover;
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
                    
                    <a href="{{ route('client.home') }}" class="sidebar-link {{ request()->routeIs('client.home') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    
                    <a href="{{ route('client.blogs.index') }}" class="sidebar-link {{ request()->routeIs('client.blogs.*') ? 'active' : '' }}">
                        <i class="fas fa-blog"></i> Blogs
                    </a>

                    <a href="{{ route('client.events.index') }}"
                            class="sidebar-link {{ request()->routeIs('client.events.*') ? 'active' : '' }}">
                            <i class="fas fa-ticket-alt"></i> Events
                        </a>
                    
                    <a href="{{ route('client.reservations.index') }}" class="sidebar-link {{ request()->routeIs('client.reservations*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i> Reservations
                    </a>
                    
                    <a href="{{ route('client.favorites') }}" class="sidebar-link {{ request()->routeIs('client.favorites*') ? 'active' : '' }}">
                        <i class="fas fa-heart"></i> Favorites
                    </a>
                    
                    <a href="{{ route('client.reviews') }}" class="sidebar-link {{ request()->routeIs('client.reviews*') ? 'active' : '' }}">
                        <i class="fas fa-star"></i> Reviews
                    </a>
                </div>
                
                <div class="sidebar-divider"></div>
                
                <div class="mb-4">
                    <h6 class="text-uppercase text-muted small fw-bold mb-3">Account</h6>
                    
                    <a href="{{ route('client.profile.show') }}" class="sidebar-link {{ request()->routeIs('client.profile*') ? 'active' : '' }}">
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
                        <h3 class="mb-1">My Reservations</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Reservations</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0">
                        <div class="d-flex justify-content-md-end">
                            <a href="{{ route('client.events.index') }}" class="btn btn-primary">
                                <i class="fas fa-calendar-plus me-2"></i> Browse Events
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Reservations List -->
            <div class="row g-4">
                @forelse($reservations as $reservation)
                    <div class="col-md-6">
                        <div class="card reservation-card h-100">
                            @if($reservation->event && $reservation->event->image)
                                <img src="{{ asset('storage/' . $reservation->event->image) }}" class="card-img-top event-image" alt="{{ $reservation->event->name }}">
                            @else
                                <div class="card-img-top event-image bg-light d-flex justify-content-center align-items-center">
                                    <i class="fas fa-calendar-day fa-3x text-muted"></i>
                                </div>
                            @endif
                            
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0">
                                        @if($reservation->event)
                                            {{ $reservation->event->name }}
                                        @else
                                            Event Details Unavailable
                                        @endif
                                    </h5>
                                    <span class="badge status-{{ $reservation->status }} status-badge">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="card-text mb-1">
                                        <i class="far fa-calendar-alt me-2 text-primary"></i>
                                        {{ $reservation->date->format('M d, Y') }}
                                    </p>
                                    
                                    @if($reservation->event)
                                        <p class="card-text mb-1">
                                            <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                            {{ $reservation->event->location }}
                                        </p>
                                        
                                        <p class="card-text">
                                            <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                            ${{ number_format($reservation->event->price, 2) }}
                                        </p>
                                    @endif
                                </div>
                                
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('client.reservations.show', $reservation->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-info-circle me-1"></i> View Details
                                    </a>
                                    
                                    @if($reservation->status === 'pending' || $reservation->status === 'confirmed')
                                        <form action="{{ route('client.reservations.cancel', $reservation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-outline-danger cancel-reservation-btn">
                                                <i class="fas fa-times-circle me-1"></i> Cancel
                                            </button>
                                        </form>
                                    @endif

                                    
                                </div>
                            </div>
                            
                            <div class="card-footer bg-white">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i> Reserved on {{ $reservation->created_at->format('M d, Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5 bg-light rounded">
                            <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
                            <h4 class="mb-3">No Reservations Found</h4>
                            <p class="text-muted mb-4">You haven't made any reservations yet. Discover exciting events and book your next adventure!</p>
                            <a href="{{ route('events.index') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i> Browse Events
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection