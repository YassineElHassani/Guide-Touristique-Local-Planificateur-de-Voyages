@extends('layouts.template')

@section('title', 'Guide Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-xl-2 px-0 bg-white shadow-sm" style="min-height: 100vh;">
            <div class="d-flex flex-column flex-shrink-0 p-3">
                <div class="text-center mb-4">
                    <img src="https://cdn.prod.website-files.com/62d84e447b4f9e7263d31e94/6399a4d27711a5ad2c9bf5cd_ben-sweet-2LowviVHZ-E-unsplash-1.jpeg" alt="Profile" class="rounded-circle mb-3" width="90" height="90">
                    <h5 class="mb-1">{{ Auth::user()->first_name ?? '' }} {{ Auth::user()->last_name ?? '' }}</h5>
                    <span class="badge bg-success rounded-pill">Local Guide</span>
                </div>
                
                <hr>
                
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item mb-2">
                        <a href="{{ route('guide.dashboard') }}" class="nav-link {{ request()->routeIs('guide.dashboard') ? 'active' : 'text-dark' }}">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('guide.events') }}" class="nav-link text-dark">
                            <i class="fas fa-calendar-alt me-2"></i> My Events
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('guide.reservations') }}" class="nav-link text-dark">
                            <i class="fas fa-users me-2"></i> Reservations
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('guide.reviews') }}" class="nav-link text-dark">
                            <i class="fas fa-star me-2"></i> Reviews
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('guide.statistics') }}" class="nav-link text-dark">
                            <i class="fas fa-chart-line me-2"></i> Statistics
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('guide.events') }}" class="nav-link text-dark">
                            <i class="fas fa-money-bill-wave me-2"></i> Earnings
                        </a>
                    </li>
                </ul>
                
                <hr>
                
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark">
                            <i class="fas fa-user-cog me-2"></i> Profile Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9 col-xl-10 bg-light">
            <div class="p-4">
                <!-- Page Title -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">@yield('dashboard-title', 'Dashboard')</h2>
                    <div>
                        @yield('dashboard-actions')
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="dashboard-content">
                    @yield('dashboard-content')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection