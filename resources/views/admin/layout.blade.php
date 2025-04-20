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
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #4338ca;
            --accent-color: #10b981;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --gray-color: #64748b;
            --light-gray: #e2e8f0;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark-color);
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            flex: 1;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background-color: white;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--light-gray);
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar-brand i {
            margin-right: 0.75rem;
            font-size: 1.5rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--gray-color);
            padding: 0.75rem 1.5rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-item {
            padding: 0.5rem 0;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--dark-color);
            text-decoration: none;
            border-radius: 0.25rem;
            margin: 0 0.75rem;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
        }

        .sidebar-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        .sidebar-link i {
            width: 24px;
            margin-right: 0.75rem;
        }

        .sidebar-dropdown .sidebar-link {
            padding-left: 3.25rem;
        }

        .sidebar-divider {
            height: 1px;
            background-color: var(--light-gray);
            margin: 1rem 1.5rem;
        }

        .content {
            flex: 1;
            margin-left: 260px;
            transition: all 0.3s ease;
        }

        /* Content Styles */
        .topbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .toggle-sidebar {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.25rem;
            color: var(--dark-color);
        }

        .user-dropdown {
            display: flex;
            align-items: center;
        }

        .user-dropdown img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin-right: 0.75rem;
        }

        .content-wrapper {
            padding: 1.5rem;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: transparent;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--light-gray);
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        .stat-card {
            border-radius: 0.75rem;
            padding: 1.25rem;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            margin-bottom: 1rem;
            color: white;
        }

        .stat-title {
            color: var(--gray-color);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        /* Table Styles */
        .table-responsive {
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8fafc;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 0.75rem 1rem;
            color: var(--gray-color);
            border-top: none;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid var(--light-gray);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(37, 99, 235, 0.05);
        }

        /* Form Styles */
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.625rem 1rem;
            border: 1px solid var(--light-gray);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
        }

        .form-select {
            border-radius: 0.5rem;
            padding: 0.625rem 1rem;
            border: 1px solid var(--light-gray);
            background-position: right 1rem center;
        }

        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
        }

        /* Button Styles */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
            border-radius: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #dc2626;
            border-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .btn-success {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            border-radius: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #059669;
            border-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .content {
                margin-left: 0;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .toggle-sidebar {
                display: block;
            }
        }
    </style>

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
                <div class="sidebar-heading">System</div>

                <div class="sidebar-item">
                    <a href="#" class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('admin.analytics.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.analytics*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i> Analytics
                    </a>
                </div>

                <div class="sidebar-divider"></div>

                <div class="sidebar-item">
                    <a href="{{ route('index') }}" class="sidebar-link">
                        <i class="fas fa-globe"></i> View Site
                    </a>
                </div>

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
                            <li><a class="dropdown-item" href="{{ route('admin.profile.index') }}">My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}">Settings</a></li>
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
