@extends('layouts.template')

@section('title', $categoryObj->name)

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <h1 class="mb-4">{{ $categoryObj->name }}</h1>
                    <p class="mb-5">{{ $categoryObj->description ?? 'Explore our amazing ' . $categoryObj->name . ' destinations around the world.' }}</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Destinations List -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('destinations.index') }}">Destinations</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $categoryObj->name }}</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold">{{ $categoryObj->name }} Destinations</h2>
                    <p class="text-muted">Showing {{ count($destinations) }} destinations</p>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex justify-content-lg-end align-items-center mt-3 mt-lg-0">
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
            
            <!-- Filter and Results -->
            <div class="row g-4">
                <!-- Filters Sidebar -->
                <div class="col-lg-3">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3">Filters</h5>
                            
                            <form action="{{ route('destinations.by-category', $categoryObj->name) }}" method="GET">
                                <!-- Price Range -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3">Price Range</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="price1" name="price[]" value="1">
                                        <label class="form-check-label" for="price1">$</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="price2" name="price[]" value="2">
                                        <label class="form-check-label" for="price2">$$</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="price3" name="price[]" value="3">
                                        <label class="form-check-label" for="price3">$$$</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="price4" name="price[]" value="4">
                                        <label class="form-check-label" for="price4">$$$$</label>
                                    </div>
                                </div>
                                
                                <!-- Rating -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3">Rating</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="rating" id="rating5" value="5">
                                        <label class="form-check-label" for="rating5">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="rating" id="rating4" value="4">
                                        <label class="form-check-label" for="rating4">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="far fa-star text-warning"></i>
                                            & Up
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="rating" id="rating3" value="3">
                                        <label class="form-check-label" for="rating3">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="far fa-star text-warning"></i>
                                            <i class="far fa-star text-warning"></i>
                                            & Up
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rating" id="rating0" value="0" checked>
                                        <label class="form-check-label" for="rating0">
                                            Show All
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Features -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3">Features</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="feature1" name="features[]" value="family-friendly">
                                        <label class="form-check-label" for="feature1">Family Friendly</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="feature2" name="features[]" value="accessible">
                                        <label class="form-check-label" for="feature2">Accessible</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="feature3" name="features[]" value="guided-tours">
                                        <label class="form-check-label" for="feature3">Guided Tours</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="feature4" name="features[]" value="free-wifi">
                                        <label class="form-check-label" for="feature4">Free WiFi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="feature5" name="features[]" value="parking">
                                        <label class="form-check-label" for="feature5">Parking Available</label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                                <button type="reset" class="btn btn-outline-secondary w-100 mt-2">Reset Filters</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Popular Searches -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3">Popular in {{ $categoryObj->name }}</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Most Visited</a>
                                <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Top Rated</a>
                                <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Family Friendly</a>
                                <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Budget Friendly</a>
                                <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Local Favorites</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Destinations Results -->
                <div class="col-lg-9">
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
                    @else
                        <div class="text-center py-5">
                            <div class="py-5">
                                <i class="fas fa-map-marked-alt fa-4x text-muted mb-4"></i>
                                <h3>No destinations found</h3>
                                <p class="text-muted">We couldn't find any destinations in this category.</p>
                                <a href="{{ route('destinations.index') }}" class="btn btn-primary mt-3">View All Destinations</a>
                            </div>
                        </div>
                    @endif
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