@extends('layouts.template')

@section('title', 'guide Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/app/css/dashboard.css') }}">
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
                        <img src="{{ $avatar }}" alt="{{ Auth::user()->first_name }}" alt="User"
                            class="user-avatar me-3">
                        <div>
                            <h5 class="mb-1">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
                            <p class="text-muted mb-0 small">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Main</h6>

                        <a href="{{ route('guide.home') }}"
                            class="sidebar-link {{ request()->routeIs('guide.home') ? 'active' : '' }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>

                        <a href="{{ route('guide.blogs.index') }}"
                            class="sidebar-link {{ request()->routeIs('guide.blogs.*') ? 'active' : '' }}">
                            <i class="fas fa-blog"></i> Blogs
                        </a>

                        <div class="sidebar-item">
                            <a href="{{ route('admin.destinations.index') }}"
                                class="sidebar-link {{ request()->routeIs('guide.destinations*') ? 'active' : '' }}">
                                <i class="fas fa-map-marker-alt"></i> Destinations
                            </a>
                        </div>

                        <a href="{{ route('guide.categories.index') }}"
                            class="sidebar-link {{ request()->routeIs('guide.categories.*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i> Categories
                        </a>

                        <a href="{{ route('guide.events.index') }}"
                            class="sidebar-link {{ request()->routeIs('guide.events.*') ? 'active' : '' }}">
                            <i class="fas fa-ticket-alt"></i> Events
                        </a>

                        <a href="{{ route('guide.reservations.index') }}"
                            class="sidebar-link {{ request()->routeIs('guide.reservations*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check"></i> Reservations
                        </a>

                        <a href="{{ route('guide.reviews') }}"
                            class="sidebar-link {{ request()->routeIs('guide.reviews*') ? 'active' : '' }}">
                            <i class="fas fa-star"></i> Reviews
                        </a>
                    </div>

                    <div class="sidebar-divider"></div>

                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Account</h6>

                        <a href="{{ route('profile.show') }}"
                            class="sidebar-link {{ request()->routeIs('guide.profile.*') ? 'active' : '' }}">
                            <i class="fas fa-user"></i> Profile
                        </a>

                        <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>

                    <div class="sidebar-divider"></div>

                    <!-- Help Card -->
                    <div class="card bg-light border-0 p-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h6 class="mb-0">Need Help?</h6>
                        </div>
                        <p class="small mb-3">Our support team is here to help you with any questions or issues.</p>
                        <a href="#" class="btn btn-sm btn-primary">Contact Support</a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Header -->
                <div class="dashboard-header mb-4 p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-1">@yield('dashboard-title', 'Dashboard')</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">@yield('dashboard-breadcrumb', 'Dashboard')</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            @yield('dashboard-actions')
                        </div>
                    </div>
                </div>

                <!-- Dashboard Content -->
                @yield('dashboard-content')
            </div>
        </div>
    </div>
@endsection
