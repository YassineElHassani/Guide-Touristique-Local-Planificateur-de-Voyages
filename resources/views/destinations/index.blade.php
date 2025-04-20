@extends('layouts.template')

@section('title', 'Explore Destinations')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <h1 class="mb-4">Explore Amazing Destinations</h1>
                    <p class="mb-5">Discover beautiful places around the world and plan your perfect trip with our local guides.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Search Form -->
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="search-form">
                    <form action="{{ route('destinations.search') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Search Destinations</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" name="query" placeholder="Search for destinations, cities, or attractions..." value="{{ request()->query('query') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Category</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <select class="form-select" name="category">
                                        <option value="" selected>All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->name }}" {{ request()->query('category') == $category->name ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Categories Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold">Explore by Category</h2>
                </div>
            </div>
            
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ route('destinations.by-category', $category->name) }}" class="text-decoration-none">
                            <div class="card h-100 text-center border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="rounded-circle bg-light d-inline-flex justify-content-center align-items-center mb-3" style="width: 70px; height: 70px;">
                                        <i class="fas fa-{{ $category->icon ?? 'map-marker-alt' }} fa-2x text-primary"></i>
                                    </div>
                                    <h5 class="card-title">{{ $category->name }}</h5>
                                    <p class="card-text text-muted">{{ $category->description ?? 'Explore ' . $category->name . ' destinations' }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- All Destinations -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <h2 class="fw-bold">All Destinations</h2>
                    <p class="text-muted">Discover all our available destinations around the world</p>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex justify-content-lg-end align-items-center">
                        <span class="me-3">Sort by:</span>
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>Popularity</option>
                            <option>Name (A-Z)</option>
                            <option>Name (Z-A)</option>
                            <option>Newest</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row g-4">
                @forelse($destinations as $destination)
                    <div class="col-lg-4 col-md-6">
                        <div class="destination-card shadow-md">
                            <img src="{{ $destination->image_url ?? 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800' }}" alt="{{ $destination->name }}">
                            @if($destination->featured ?? false)
                                <span class="badge-featured">Featured</span>
                            @endif
                            <div class="destination-card-content">
                                <span class="d-block mb-2"><i class="fas fa-map-marker-alt me-2"></i>{{ $destination->category }}</span>
                                <h3>{{ $destination->name }}</h3>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        @php
                                            $rating = $destination->average_rating ?? 4.5;
                                            $fullStars = floor($rating);
                                            $halfStar = $rating - $fullStars >= 0.5;
                                        @endphp
                                        
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $fullStars)
                                                <i class="fas fa-star text-warning"></i>
                                            @elseif($halfStar && $i == $fullStars + 1)
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        <span class="ms-2">{{ $rating }}</span>
                                    </div>
                                    <a href="{{ route('destinations.show', $destination->id) }}" class="btn btn-sm btn-light">
                                        Explore <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="py-5">
                            <i class="fas fa-map-marked-alt fa-4x text-muted mb-4"></i>
                            <h3>No destinations found</h3>
                            <p class="text-muted">We couldn't find any destinations matching your criteria.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    <nav aria-label="Destinations pagination">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Newsletter Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card border-0 shadow-lg rounded-lg p-4">
                        <div class="row align-items-center">
                            <div class="col-lg-6 mb-4 mb-lg-0">
                                <h3 class="fw-bold">Join Our Newsletter</h3>
                                <p class="text-muted mb-0">Subscribe to receive updates on new destinations, travel tips, and exclusive offers.</p>
                            </div>
                            <div class="col-lg-6">
                                <form>
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="Your email address">
                                        <button class="btn btn-primary" type="button">Subscribe</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection