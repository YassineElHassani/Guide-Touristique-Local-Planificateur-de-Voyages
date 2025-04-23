@extends('client.dashboard')

@section('title', $event->name)

@section('dashboard-title', $event->name)

@section('dashboard-actions')
<div class="d-flex">
    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-arrow-left me-1"></i> Back to Events
    </a>
    <form action="{{ route('client.favorites.add', $event->id) }}" method="POST" class="me-2">
        @csrf
        <button type="submit" class="btn btn-outline-warning">
            <i class="far fa-heart me-1"></i> Add to Favorites
        </button>
    </form>
    <a href="{{ route('client.reservations.create', $event->id) }}" class="btn btn-primary">
        <i class="fas fa-ticket-alt me-1"></i> Book Now
    </a>
</div>
@endsection

@section('dashboard-content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <!-- Event Image -->
        <div class="card mb-4 overflow-hidden">
            <div class="position-relative">
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->name }}" style="max-height: 450px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex justify-content-center align-items-center" style="height: 300px;">
                        <i class="fas fa-calendar-alt fa-5x text-secondary"></i>
                    </div>
                @endif
                <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0));">
                    <h2 class="text-white mb-1">{{ $event->name }}</h2>
                    <div class="d-flex align-items-center text-white">
                        <div class="me-3">
                            <i class="far fa-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                        </div>
                        <div class="me-3">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $event->location }}
                        </div>
                        <div class="badge bg-primary fs-6">
                            ${{ number_format($event->price, 2) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Details -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#details" data-bs-toggle="tab">Details</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#reviews" data-bs-toggle="tab">Reviews <span class="badge bg-secondary rounded-pill">{{ count($reviews) }}</span></a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#location" data-bs-toggle="tab">Location</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <!-- Details Tab -->
                    <div class="tab-pane fade show active" id="details">
                        <h5 class="card-title mb-4">About This Event</h5>
                        <p class="card-text">{{ $event->description }}</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6 class="mb-3">Event Information</h6>
                                <div class="mb-2">
                                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                                </div>
                                <div class="mb-2">
                                    <strong>Location:</strong> {{ $event->location }}
                                </div>
                                <div class="mb-2">
                                    <strong>Price:</strong> ${{ number_format($event->price, 2) }}
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h6 class="mb-3">What to Know</h6>
                                <ul>
                                    <li>Please arrive 15 minutes before the event starts</li>
                                    <li>Bring your reservation confirmation</li>
                                    <li>Comfortable shoes and clothing recommended</li>
                                    <li>Food and drinks available at additional cost</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            @php
                                $hasReservation = Auth::check() && App\Models\reservations::where('user_id', Auth::id())
                                    ->where('event_id', $event->id)
                                    ->exists();
                            @endphp
                            
                            @if($hasReservation)
                                <a href="{{ route('client.reservations') }}" class="btn btn-success">
                                    <i class="fas fa-check-circle me-2"></i> You've Booked This Event
                                </a>
                            @else
                                <a href="{{ route('client.reservations.create', $event->id) }}" class="btn btn-primary">
                                    <i class="fas fa-ticket-alt me-2"></i> Book This Event
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="reviews">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">Customer Reviews</h5>
                            
                            @php
                                $canReview = Auth::check() && App\Models\reservations::where('user_id', Auth::id())
                                    ->where('event_id', $event->id)
                                    ->where('status', 'confirmed')
                                    ->exists();
                                    
                                $hasReviewed = Auth::check() && App\Models\reviews::where('user_id', Auth::id())
                                    ->where('event_id', $event->id)
                                    ->exists();
                            @endphp
                            
                            @if($canReview && !$hasReviewed)
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                    <i class="fas fa-star me-1"></i> Write a Review
                                </button>
                            @endif
                        </div>
                        
                        @if(count($reviews) > 0)
                            <div class="mb-4">
                                @php
                                    $averageRating = $reviews->avg('rating');
                                    $reviewCount = count($reviews);
                                    $fullStars = floor($averageRating);
                                    $halfStar = $averageRating - $fullStars > 0.4 ? 1 : 0;
                                    $emptyStars = 5 - $fullStars - $halfStar;
                                @endphp
                                
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-2">
                                        @for($i = 0; $i < $fullStars; $i++)
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor
                                        
                                        @if($halfStar)
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        @endif
                                        
                                        @for($i = 0; $i < $emptyStars; $i++)
                                            <i class="far fa-star text-warning"></i>
                                        @endfor
                                    </div>
                                    <div>
                                        <strong>{{ number_format($averageRating, 1) }}</strong>
                                        <span class="text-muted">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</span>
                                    </div>
                                </div>
                            </div>

                            @foreach($reviews as $review)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                @for($i = 0; $i < $review->rating; $i++)
                                                    <i class="fas fa-star text-warning"></i>
                                                @endfor
                                                
                                                @for($i = 0; $i < (5 - $review->rating); $i++)
                                                    <i class="far fa-star text-warning"></i>
                                                @endfor
                                            </div>
                                            <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                        </div>
                                        
                                        <h6 class="mb-1">
                                            {{ $review->user ? $review->user->first_name . ' ' . $review->user->last_name : 'Anonymous' }}
                                        </h6>
                                        <p class="mb-0">{{ $review->comments }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="far fa-star fa-3x text-muted mb-3"></i>
                                <h5>No Reviews Yet</h5>
                                <p class="text-muted">Be the first to review this event.</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Location Tab -->
                    <div class="tab-pane fade" id="location">
                        <h5 class="card-title mb-4">Event Location</h5>
                        <div id="map" style="height: 400px; width: 100%;" class="rounded mb-4"></div>
                        
                        @php
                            $destination = App\Models\destinations::where('name', $event->location)->first();
                        @endphp
                        
                        @if($destination)
                            <h6>{{ $destination->name }}</h6>
                            <p class="mb-3">{{ $destination->address }}</p>
                            
                            <div class="mb-3">
                                <strong>About this location:</strong>
                                <p>{{ Str::limit($destination->description, 200) }}</p>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-info-circle me-1"></i> View Location Details
                                </a>
                            </div>
                        @else
                            <p class="mb-3"><strong>{{ $event->location }}</strong></p>
                        @endif
                        
                        <div class="d-grid">
                            <a href="https://maps.google.com/?q={{ urlencode($event->location) }}" class="btn btn-outline-secondary" target="_blank">
                                <i class="fas fa-directions me-2"></i> Get Directions on Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Booking Box -->
        <div class="card mb-4 sticky-top" style="top: 20px; z-index: 1;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Book This Event</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span class="h3">${{ number_format($event->price, 2) }}</span>
                    <span class="text-muted">per person</span>
                </div>
                
                <div class="mb-3">
                    <div class="mb-2">Event Date:</div>
                    <div class="fw-bold">{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</div>
                </div>
                
                <div class="mb-4">
                    <div class="mb-2">Location:</div>
                    <div class="fw-bold">{{ $event->location }}</div>
                </div>
                
                <div class="d-grid gap-2">
                    @php
                        $hasReservation = Auth::check() && App\Models\reservations::where('user_id', Auth::id())
                            ->where('event_id', $event->id)
                            ->exists();
                    @endphp
                    
                    @if($hasReservation)
                        <a href="{{ route('client.reservations') }}" class="btn btn-success">
                            <i class="fas fa-check-circle me-2"></i> You've Booked This Event
                        </a>
                    @else
                        <a href="{{ route('client.reservations.create', $event->id) }}" class="btn btn-primary">
                            <i class="fas fa-ticket-alt me-2"></i> Book Now
                        </a>
                    @endif
                    
                    <form action="{{ route('client.favorites.add', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning w-100">
                            <i class="far fa-heart me-2"></i> Add to Favorites
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <small class="text-muted">Secure booking</small>
                    <div>
                        <i class="fas fa-lock text-success me-1"></i>
                        <i class="fab fa-cc-visa text-muted me-1"></i>
                        <i class="fab fa-cc-mastercard text-muted me-1"></i>
                        <i class="fab fa-cc-paypal text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Events -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Related Events</h5>
            </div>
            <div class="card-body p-0">
                @php
                    $relatedEvents = App\Models\events::where('location', $event->location)
                        ->where('id', '!=', $event->id)
                        ->orderBy('date', 'asc')
                        ->take(3)
                        ->get();
                @endphp
                
                @if(count($relatedEvents) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($relatedEvents as $related)
                            <a href="{{ route('events.show', $related->id) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex align-items-center">
                                    @if($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}" class="rounded me-3" 
                                             style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $related->name }}">
                                    @else
                                        <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-calendar-alt text-secondary"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ Str::limit($related->name, 25) }}</h6>
                                        <div class="small text-muted">{{ \Carbon\Carbon::parse($related->date)->format('M d, Y') }}</div>
                                        <div class="small text-primary">${{ number_format($related->price, 2) }}</div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="mb-0">No related events found in this location.</p>
                    </div>
                @endif
            </div>
            <div class="card-footer bg-white text-center">
                <a href="{{ route('events.index') }}" class="btn btn-sm btn-outline-primary">View All Events</a>
            </div>
        </div>
    </div>
</div>

<!-- Review Modal -->
@if(Auth::check())
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <div class="star-rating">
                            <div class="d-flex">
                                @for($i = 5; $i >= 1; $i--)
                                    <div class="form-check form-check-inline me-3">
                                        <input class="form-check-input" type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rating{{ $i }}">{{ $i }} star{{ $i > 1 ? 's' : '' }}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="comments" class="form-label">Your Review</label>
                        <textarea class="form-control" id="comments" name="comments" rows="4" required></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('NEXT_PUBLIC_GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
<script>
    function initMap() {
        @php
            $destination = \App\Models\destinations::where('name', $event->location)->first();
            $coordinates = $destination ? $destination->coordinates : '0,0';
        @endphp
        
        const coordinates = "{{ $coordinates }}".split(',');
        const lat = parseFloat(coordinates[0]);
        const lng = parseFloat(coordinates[1]);
        const location = { lat, lng };
        
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: location,
        });
        
        const marker = new google.maps.Marker({
            position: location,
            map: map,
            title: "{{ $event->name }}"
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Bootstrap tabs initialization is automatic in BS5
        
        // Review stars hover effect (if needed)
        const ratingInputs = document.querySelectorAll('input[name="rating"]');
        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Add visual feedback for rating selection if desired
            });
        });
    });
</script>
@endpush