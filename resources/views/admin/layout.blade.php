<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('app/css/admin.css') }}">
    @stack('styles')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard.index') }}" class="sidebar-brand">
                    <i class="fas fa-compass"></i> Admin Panel
                </a>
            </div>

            <div class="sidebar-nav">
                <div class="sidebar-item">
                    <a href="{{ route('admin.dashboard.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('index') }}" class="sidebar-link">
                        <i class="fas fa-globe"></i> View Site
                    </a>
                </div>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Management</div>

                <div class="sidebar-item">
                    <a href="{{ route('admin.users.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Users
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('admin.destinations.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.destinations*') ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt"></i> Destinations
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('admin.events.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.events*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i> Events
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('admin.categories.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i> Categories
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('admin.blogs.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.blogs*') ? 'active' : '' }}">
                        <i class="fas fa-blog"></i> Blog Posts
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('admin.reviews.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                        <i class="fas fa-star"></i> Reviews
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('admin.reservations.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.reservations*') ? 'active' : '' }}">
                        <i class="fas fa-ticket-alt"></i> Reservations
                    </a>
                </div>

                <div class="sidebar-divider"></div>

                <div class="sidebar-item">
                    <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </aside>

        <!-- Content -->
        <div class="content">
            <header class="topbar">
                <button class="toggle-sidebar" id="toggle-sidebar">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="user-dropdown">
                    @php
                        $avatar = Auth::user()->picture
                            ? (Str::startsWith(Auth::user()->picture, 'http')
                                ? Auth::user()->picture
                                : asset('storage/' . Auth::user()->picture))
                            : asset('/assets/images/default-avatar.png');
                    @endphp
                    <img src="{{ $avatar }}" alt="{{ Auth::user()->first_name }}" alt="Admin">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->first_name ?? 'Admin' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('users.profile', Auth::id()) }}">My Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </header>

            <div class="content-wrapper">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-1">@yield('heading', 'Dashboard')</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Admin</a>
                                </li>
                                @yield('breadcrumbs')
                            </ol>
                        </nav>
                    </div>
                    <div>
                        @yield('actions')
                    </div>
                </div>

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar
            const toggleBtn = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('sidebar');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
