@extends('layouts.template')

@section('title', 'Search Results')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <h1 class="mb-4">Search Results</h1>
                    <p class="mb-5">Showing results for "{{ $query }}"</p>
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
                                    <input type="text" class="form-control" name="query" placeholder="Search for destinations, cities, or attractions..." value="{{ $query }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Category</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <select class="form-select" name="category">
                                        <option value="" {{ !$categoryFilter ? 'selected' : '' }}>All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->name }}" {{ $categoryFilter == $category->name ? 'selected' : '' }}>
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
    
    <!-- Search Results -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('destinations.index') }}">Destinations</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Search Results</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold">Search Results</h2>
                    <p class="text-muted">Found {{ count($destinations) }} results for "{{ $query }}" {{ $categoryFilter ? 'in ' . $categoryFilter : '' }}</p>
                </div>
            </div>
            
            @if(count($destinations) > 0)
                <div class="row g-4">
                    @foreach($destinations as $destination)
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
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    <nav aria-label="Search results pagination">
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
            @else
                <div class="text-center py-5">
                    <div class="py-5">
                        <i class="fas fa-search fa-4x text-muted mb-4"></i>
                        <h3>No results found</h3>
                        <p class="text-muted">We couldn't find any destinations matching your search criteria.</p>
                        <div class="mt-4">
                            <h5>Suggestions:</h5>
                            <ul class="list-unstyled">
                                <li>Check the spelling of your search term</li>
                                <li>Try using more general keywords</li>
                                <li>Try searching for a different destination</li>
                                <li>Browse destinations by category instead</li>
                            </ul>
                        </div>
                        <a href="{{ route('destinations.index') }}" class="btn btn-primary mt-3">Browse All Destinations</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection