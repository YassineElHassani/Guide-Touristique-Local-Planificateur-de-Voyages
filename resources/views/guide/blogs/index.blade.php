@extends('layouts.template')

@section('title', 'Blogs')

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

        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
        }

        .featured-badge {
            position: absolute;
            top: 15px;
            left: 15px;
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

                        <a href="{{ route('guide.home') }}"
                            class="sidebar-link {{ request()->routeIs('guide.home') ? 'active' : '' }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>

                        <a href="{{ route('guide.blogs.index') }}"
                            class="sidebar-link {{ request()->routeIs('guide.blogs.index') ? 'active' : '' }}">
                            <i class="fas fa-blog"></i> All Blogs
                        </a>

                        <a href="{{ route('guide.blogs.my-blogs') }}"
                            class="sidebar-link {{ request()->routeIs('guide.blogs.my-blogs') ? 'active' : '' }}">
                            <i class="fas fa-user-edit"></i> My Blogs
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
                            class="sidebar-link {{ request()->routeIs('guide.profile*') ? 'active' : '' }}">
                            <i class="fas fa-user"></i> Profile
                        </a>

                        <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>

                    <div class="sidebar-divider"></div>

                    <!-- Categories Filter -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Categories</h6>
                        <div class="list-group">
                            <a href="{{ route('guide.blogs.index') }}"
                                class="list-group-item list-group-item-action {{ request()->routeIs('guide.blogs.index') && !request()->query('category') ? 'active' : '' }}">
                                All Categories
                            </a>
                            @foreach ($categories as $category)
                                <a href="{{ route('guide.blogs.index', ['category' => $category]) }}"
                                    class="list-group-item list-group-item-action {{ request()->query('category') == $category ? 'active' : '' }}">
                                    {{ $category }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Header -->
                <div class="dashboard-header mb-4 p-4">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h3 class="mb-1">Blogs</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('guide.home') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-5 mt-3 mt-md-0">
                            <div class="d-flex justify-content-md-end">
                                <form action="{{ route('guide.blogs.index') }}" method="GET"
                                    class="d-flex me-2 flex-grow-1">
                                    <input type="text" name="search" class="form-control" placeholder="Search blogs..."
                                        value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary ms-2">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                                <a href="{{ route('guide.blogs.my-blogs') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-user-edit me-1"></i> My Blogs
                                </a>
                                <a href="{{ route('guide.blogs.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-1"></i> New
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Blogs Section (Carousel) -->
                @if ($featuredBlogs->count() > 0)
                    <div class="mb-4">
                        <div id="featuredBlogsCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($featuredBlogs as $index => $featuredBlog)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <div class="position-relative">
                                            @if ($featuredBlog->image)
                                                <img src="{{ asset('storage/' . $featuredBlog->image) }}"
                                                    class="d-block w-100 rounded" style="height: 350px; object-fit: cover;"
                                                    alt="{{ $featuredBlog->title }}">
                                            @else
                                                <div class="d-block w-100 bg-light rounded d-flex align-items-center justify-content-center"
                                                    style="height: 350px;">
                                                    <i class="fas fa-image fa-4x text-muted"></i>
                                                </div>
                                            @endif

                                            <div class="carousel-caption text-start"
                                                style="background: rgba(0,0,0,0.6); left: 0; right: 0; bottom: 0; padding: 20px;">
                                                <span class="badge bg-warning mb-2">Featured</span>
                                                <h3>{{ $featuredBlog->title }}</h3>
                                                <p>{{ Str::limit($featuredBlog->excerpt, 120) }}</p>
                                                <a href="{{ route('guide.blogs.show', $featuredBlog->slug) }}"
                                                    class="btn btn-primary btn-sm">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#featuredBlogsCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#featuredBlogsCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- All Blogs -->
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

                                        @if ($blog->category)
                                            <span class="badge bg-info category-badge">
                                                {{ $blog->category }}
                                            </span>
                                        @endif

                                        @if ($blog->featured)
                                            <span class="badge bg-warning featured-badge">
                                                <i class="fas fa-star me-1"></i> Featured
                                            </span>
                                        @endif
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">
                                            <a href="{{ route('guide.blogs.show', $blog->slug) }}"
                                                class="text-decoration-none text-dark">
                                                {{ Str::limit($blog->title, 50) }}
                                            </a>
                                        </h5>

                                        <div class="text-muted small mb-3">
                                            <span><i class="far fa-calendar-alt me-1"></i>
                                                {{ $blog->created_at->format('M d, Y') }}</span>
                                            <span class="ms-3"><i class="far fa-comments me-1"></i>
                                                {{ $blog->comments_count }}</span>
                                            <span class="ms-3"><i class="far fa-eye me-1"></i>
                                                {{ $blog->views }}</span>
                                        </div>

                                        <p class="card-text flex-grow-1">{{ Str::limit($blog->excerpt, 100) }}</p>

                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <a href="{{ route('guide.blogs.show', $blog->slug) }}"
                                                class="btn btn-sm btn-primary">
                                                Read More
                                            </a>

                                            @if (Auth::id() === $blog->user_id)
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('guide.blogs.edit', $blog->slug) }}">
                                                                <i class="fas fa-edit me-1 text-success"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('guide.blogs.update-status', $blog->id) }}"
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
                                                                        <i class="fas fa-eye me-1 text-success"></i>
                                                                        Publish
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('guide.blogs.destroy', $blog->slug) }}"
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
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white">
                                        <div class="d-flex align-items-center">
                                            @php
                                                $avatar =
                                                    $blog->user && $blog->user->picture
                                                        ? (Str::startsWith($blog->user->picture, 'http')
                                                            ? $blog->user->picture
                                                            : asset('storage/' . $blog->user->picture))
                                                        : asset('/assets/images/default-avatar.png');
                                            @endphp
                                            <img src="{{ $avatar }}"
                                                alt="{{ $blog->user ? $blog->user->first_name : 'User' }}"
                                                class="rounded-circle me-2"
                                                style="width: 30px; height: 30px; object-fit: cover;">
                                            <span class="small">
                                                {{ $blog->user ? $blog->user->first_name . ' ' . $blog->user->last_name : 'Unknown User' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="text-center py-5 bg-light rounded">
                                <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                                <h4>No Blog Posts Found</h4>
                                <p class="text-muted">
                                    @if (request('search'))
                                        No blogs matching your search criteria.
                                    @elseif(request('category'))
                                        No blogs in this category yet.
                                    @else
                                        No blog posts have been published yet.
                                    @endif
                                </p>
                                <a href="{{ route('guide.blogs.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus me-1"></i> Create a Blog Post
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

@push('scripts')
    <script>
        // Initialize the carousel with a 5-second interval
        document.addEventListener('DOMContentLoaded', function() {
            var myCarousel = document.getElementById('featuredBlogsCarousel');
            if (myCarousel) {
                var carousel = new bootstrap.Carousel(myCarousel, {
                    interval: 5000
                });
            }
        });
    </script>
@endpush
