@extends('layouts.template')

@section('title', 'My Blogs')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/app/css/dashboard.css') }}">
    <style>
        .blog-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .blog-image {
            height: 200px;
            object-fit: cover;
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
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
                            class="sidebar-link {{ request()->routeIs('client.blogs.index') ? 'active' : '' }}">
                            <i class="fas fa-blog"></i> All Blogs
                        </a>

                        <a href="{{ route('client.blogs.my-blogs') }}"
                            class="sidebar-link {{ request()->routeIs('client.blogs.my-blogs') ? 'active' : '' }}">
                            <i class="fas fa-user-edit"></i> My Blogs
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
                        <div class="col-md-7">
                            <h3 class="mb-1">My Blogs</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('client.blogs.index') }}">Blogs</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">My Blogs</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-5 mt-3 mt-md-0">
                            <div class="d-flex justify-content-md-end">
                                <a href="{{ route('client.blogs.index') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-blog me-1"></i> All Blogs
                                </a>
                                <a href="{{ route('client.blogs.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-1"></i> Create New
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Blog List -->
                <div class="row g-4">
                    @if ($blogs->count() > 0)
                        @foreach ($blogs as $blog)
                            <div class="col-md-6 col-lg-4">
                                <div class="card blog-card h-100">
                                    <div class="position-relative">
                                        @if ($blog->image)
                                            <img src="{{ asset('storage/' . $blog->image) }}"
                                                class="card-img-top blog-image" alt="{{ $blog->title }}">
                                        @else
                                            <div
                                                class="bg-light d-flex align-items-center justify-content-center blog-image">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                            </div>
                                        @endif

                                        <span class="badge bg-{{ $blog->published ? 'success' : 'warning' }} status-badge">
                                            {{ $blog->published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">
                                            <a href="{{ route('client.blogs.show', $blog->slug) }}"
                                                class="text-decoration-none text-dark">
                                                {{ Str::limit($blog->title, 50) }}
                                            </a>
                                        </h5>

                                        <div class="text-muted small mb-3">
                                            <span><i class="far fa-calendar-alt me-1"></i>
                                                {{ $blog->created_at->format('M d, Y') }}</span>
                                            <span class="ms-3"><i class="far fa-eye me-1"></i>
                                                {{ $blog->views ?? 0 }}</span>
                                        </div>

                                        <p class="card-text flex-grow-1">{{ Str::limit($blog->excerpt, 100) }}</p>

                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <a href="{{ route('client.blogs.show', $blog->slug) }}"
                                                class="btn btn-sm btn-primary">
                                                View
                                            </a>

                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('client.blogs.edit', $blog->slug) }}">
                                                            <i class="fas fa-edit me-1 text-success"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('client.blogs.update-status', $blog->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="published"
                                                                value="{{ $blog->published ? '0' : '1' }}">
                                                            <button type="submit" class="dropdown-item">
                                                                @if ($blog->published)
                                                                    <i class="fas fa-eye-slash me-1 text-warning"></i>
                                                                    Unpublish
                                                                @else
                                                                    <i class="fas fa-eye me-1 text-success"></i> Publish
                                                                @endif
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('client.blogs.destroy', $blog->slug) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-trash me-1 text-danger"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="text-center py-5 bg-light rounded">
                                <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                                <h4>No Blog Posts Yet</h4>
                                <p class="text-muted">
                                    You haven't created any blog posts yet. Start sharing your travel experiences!
                                </p>
                                <a href="{{ route('client.blogs.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus me-1"></i> Create Your First Blog
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection