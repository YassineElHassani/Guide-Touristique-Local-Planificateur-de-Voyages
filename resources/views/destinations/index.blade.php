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