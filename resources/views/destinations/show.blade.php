@extends('layouts.template')

@section('title', $destination->name)

@push('styles')
<style>
    .gallery-img {
        height: 200px;
        object-fit: cover;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .gallery-img:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .main-image {
        height: 400px;
        object-fit: cover;
        border-radius: 1rem;
    }
    
    .map-container {
        height: 400px;
        border-radius: 1rem;
        overflow: hidden;
    }
    
    .review-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
    }
    
    .review-date {
        font-size: 0.85rem;
        color: #64748b;
    }
    
    .favorite-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background-color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .favorite-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .weather-card {
        border-radius: 1rem;
        background-color: #f0f9ff;
        border: none;
    }
    
    .review-form {
        border-radius: 1rem;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .rating-input {
        display: none;
    }
    
    .rating-label {
        cursor: pointer;
        font-size: 1.5rem;
        color: #d1d5db;
    }
    
    .rating-label:hover,
    .rating-label:hover ~ .rating-label,
    .rating-input:checked ~ .rating-label {
        color: #f59e0b;
    }
    
    .rating-group {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
</style>
@endpush

@section('content')
    <div class="container py-5">
        <!-- Destination Header -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('destinations.index') }}">Destinations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $destination->name }}</li>
                    </ol>
                </nav>
                <h1 class="fw-bold mb-2">{{ $destination->name }}</h1>
                <div class="d-flex align-items-center mb-3">
                    <span class="me-3">
                        <i class="fas fa-map-marker-alt text-primary me-1"></i>
                        {{ $destination->address }}
                    </span>
                    <span class="badge bg-primary rounded-pill">{{ $destination->category }}</span>
                </div>
                
                <div class="d-flex align-items-center mb-3">
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
                    <span class="ms-2">{{ $rating }} ({{ count($reviews) }} reviews)</span>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex justify-content-lg-end gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-share-alt me-2"></i> Share
                    </button>
                    
                    @auth
                        @if($isFavorite)
                            <form action="{{ route('destinations.remove-favorite', $destination->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-heart me-2"></i> Saved
                                </button>
                            </form>
                        @else
                            <form action="{{ route('destinations.add-favorite', $destination->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="far fa-heart me-2"></i> Save
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="far fa-heart me-2"></i> Save
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Image Gallery -->
        <div class="row mb-5">
            <div class="col-lg-8 position-relative mb-4 mb-lg-0">
                <img src="{{ $destination->image_url ?? 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800' }}" alt="{{ $destination->name }}" class="img-fluid main-image w-100">
                
                @auth
                    @if($isFavorite)
                        <form action="{{ route('destinations.remove-favorite', $destination->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="favorite-btn">
                                <i class="fas fa-heart text-danger"></i>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('destinations.add-favorite', $destination->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="favorite-btn">
                                <i class="far fa-heart"></i>
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </a>
                @endauth
            </div>
            <div class="col-lg-4">
                <div class="row g-3">
                    @for($i = 1; $i <= 4; $i++)
                        <div class="col-6">
                            <img src="https://images.unsplash.com/photo-{{ 1520250497591 + $i }}-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400" alt="{{ $destination->name }} gallery image" class="img-fluid w-100 gallery-img">
                        </div>
                    @endfor
                    <div class="col-12">
                        <button class="btn btn-outline-primary w-100">View All Photos</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 pe-lg-5">
                <!-- Description -->
                <div class="mb-5">
                    <h3 class="fw-bold mb-4">About {{ $destination->name }}</h3>
                    <div class="mb-4">
                        {!! nl2br(e($destination->description)) !!}
                    </div>
                    
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <span class="badge bg-light text-dark p-2">
                            <i class="fas fa-clock text-primary me-2"></i> Open Hours: 9:00 AM - 6:00 PM
                        </span>
                        <span class="badge bg-light text-dark p-2">
                            <i class="fas fa-phone text-primary me-2"></i> Contact: +1 123-456-7890
                        </span>
                        <span class="badge bg-light text-dark p-2">
                            <i class="fas fa-globe text-primary me-2"></i> Website: example.com
                        </span>
                    </div>
                </div>
                
                <!-- Map -->
                <div class="mb-5">
                    <h3 class="fw-bold mb-4">Location & Directions</h3>
                    <div class="map-container mb-3">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.991626882122!2d2.2922926156744856!3d48.85837360866272!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e2964e34e2d%3A0x8ddca9ee380ef7e0!2sEiffel%20Tower!5e0!3m2!1sen!2sfr!4v1651152518714!5m2!1sen!2sfr" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <p>{{ $destination->address }}</p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-directions me-2"></i> Get Directions
                        </button>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-map me-2"></i> View Larger Map
                        </button>
                    </div>
                </div>
                
                <!-- Weather -->
                <div class="mb-5">
                    <h3 class="fw-bold mb-4">Weather Forecast</h3>
                    <div class="row g-3">
                        @for($i = 0; $i < 5; $i++)
                            <div class="col">
                                <div class="card weather-card h-100 text-center">
                                    <div class="card-body p-3">
                                        <p class="mb-2">{{ date('D', strtotime("+$i day")) }}</p>
                                        <i class="fas fa-sun fa-2x text-warning mb-2"></i>
                                        <h5 class="mb-0">{{ 20 + rand(-5, 5) }}°C</h5>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                
                <!-- Reviews -->
                <div class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold mb-0">Reviews ({{ count($reviews) }})</h3>
                        <div>
                            <select class="form-select form-select-sm">
                                <option>Most Recent</option>
                                <option>Highest Rated</option>
                                <option>Lowest Rated</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Review Form -->
                    @auth
                        <div class="card mb-4 review-form">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-3">Write a Review</h5>
                                <form action="{{ route('reviews.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="destination_id" value="{{ $destination->id }}">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Rating</label>
                                        <div class="rating-group">
                                            @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" class="rating-input" name="rating" id="rating-{{ $i }}" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                                <label for="rating-{{ $i }}" class="rating-label me-1">★</label>
                                            @endfor
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Your Review</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            Please <a href="{{ route('login') }}" class="alert-link">log in</a> to leave a review.
                        </div>
                    @endauth
                    
                    <!-- Review List -->
                    @forelse($reviews as $review)
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex">
                                    <img src="https://randomuser.me/api/portraits/{{ $review->user_id % 2 == 0 ? 'women' : 'men' }}/{{ $review->user_id % 100 }}.jpg" alt="User" class="review-avatar me-3">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="mb-0">{{ $review->user->name ?? 'Anonymous' }}</h5>
                                            <span class="review-date">{{ $review->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="card-text">{{ $review->comment }}</p>
                                        @if(Auth::check() && Auth::id() == $review->user_id)
                                            <div class="d-flex gap-2 mt-3">
                                                <a href="{{ route('client.reviews.edit', $review->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                                <form action="{{ route('client.reviews.delete', $review->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 bg-light rounded-lg">
                            <i class="far fa-comment-alt fa-3x text-muted mb-3"></i>
                            <h5>No Reviews Yet</h5>
                            <p class="text-muted">Be the first to review this destination!</p>
                        </div>
                    @endforelse
                    
                    <!-- Pagination -->
                    @if(count($reviews) > 5)
                        <div class="d-flex justify-content-center mt-4">
                            <nav aria-label="Reviews pagination">
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
                    @endif
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Add to Itinerary Card -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3">Add to Your Itinerary</h5>
                        @auth
                            <form action="{{ route('client.itineraries.add-destination') }}" method="POST">
                                @csrf
                                <input type="hidden" name="destination_id" value="{{ $destination->id }}">
                                
                                <div class="mb-3">
                                    <label for="itinerary_id" class="form-label">Select Itinerary</label>
                                    <select class="form-select" id="itinerary_id" name="itinerary_id" required>
                                        <option value="">-- Select Itinerary --</option>
                                        <!-- This would be populated from the controller -->
                                        <option value="new">+ Create New Itinerary</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="visit_date" class="form-label">Visit Date</label>
                                    <input type="date" class="form-control" id="visit_date" name="visit_date" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-plus me-2"></i> Add to Itinerary
                                </button>
                            </form>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Please <a href="{{ route('login') }}" class="alert-link">log in</a> to add this destination to your itinerary.
                            </div>
                        @endauth
                    </div>
                </div>
                
                <!-- Related Events Card -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3">Upcoming Events</h5>
                        <div class="list-group list-group-flush">
                            @for($i = 1; $i <= 3; $i++)
                                <a href="#" class="list-group-item list-group-item-action border-0 px-0">
                                    <div class="d-flex">
                                        <div class="bg-primary text-white rounded text-center p-2 me-3" style="min-width: 50px;">
                                            <span class="d-block fw-bold">{{ date('d', strtotime("+$i week")) }}</span>
                                            <small>{{ date('M', strtotime("+$i week")) }}</small>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ ['Summer Festival', 'Wine Tasting', 'Cultural Tour'][$i-1] }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i> {{ rand(10, 18) }}:00
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            @endfor
                        </div>
                        <a href="#" class="btn btn-outline-primary w-100 mt-3">View All Events</a>
                    </div>
                </div>
                
                <!-- Nearby Destinations Card -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3">Nearby Destinations</h5>
                        @for($i = 1; $i <= 3; $i++)
                            <div class="d-flex mb-3">
                                <img src="https://images.unsplash.com/photo-{{ 1520250497591 + $i*10 }}-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=100" alt="Nearby destination" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-1">Nearby Destination {{ $i }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i> {{ rand(1, 10) }} km away
                                    </small>
                                    <div>
                                        <small>
                                            @for($j = 1; $j <= 5; $j++)
                                                <i class="{{ $j <= 4 ? 'fas' : 'far' }} fa-star text-warning" style="font-size: 0.7rem;"></i>
                                            @endfor
                                            <span class="ms-1">{{ number_format(4 + rand(0, 10)/10, 1) }}</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endfor
                        <a href="#" class="btn btn-outline-primary w-100 mt-2">Explore Nearby</a>
                    </div>
                </div>
                
                <!-- Local Guide Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3">Meet a Local Guide</h5>
                        <div class="text-center mb-3">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Local Guide" class="rounded-circle" width="80" height="80">
                            <h5 class="mt-3 mb-1">Jean Dupont</h5>
                            <p class="text-muted small">Professional Guide - 5 years experience</p>
                            <div class="mb-2">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star-half-alt text-warning"></i>
                                <span class="ms-1">4.8 (124 reviews)</span>
                            </div>
                        </div>
                        <p class="small">I'm a certified local guide with extensive knowledge of the area. I can provide personalized tours and insider tips to make your visit unforgettable.</p>
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-primary">Contact Guide</a>
                            <a href="#" class="btn btn-outline-primary">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection