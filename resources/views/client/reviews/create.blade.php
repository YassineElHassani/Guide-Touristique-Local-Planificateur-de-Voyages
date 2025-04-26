@extends('client.dashboard')

@section('dashboard-title', 'Write a Review')
@section('dashboard-breadcrumb', 'Write Review')

@section('dashboard-actions')
<a href="{{ route('client.reviews') }}" class="btn btn-outline-primary">
    <i class="fas fa-arrow-left me-1"></i> Back to Reviews
</a>
@endsection

@section('dashboard-content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Write Your Review</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    
                    <!-- Event Information -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            @if($event && $event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="rounded me-3" width="60" height="60" alt="{{ $event->name }}" style="object-fit: cover;">
                            @else
                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-calendar-alt text-secondary fa-2x"></i>
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-0">{{ $event->name ?? 'Event' }}</h5>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $event->location ?? 'Unknown Location' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden fields -->
                    @if(isset($event->id))
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                    @endif
                    
                    @if(isset($destination->id))
                        <input type="hidden" name="destination_id" value="{{ $destination->id }}">
                    @endif
                    
                    <!-- Rating -->
                    <div class="mb-4">
                        <label class="form-label">Rating</label>
                        <div class="rating-input">
                            <div class="d-flex align-items-center">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="visually-hidden" {{ old('rating') == $i ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" class="me-2 fs-3 rating-star">
                                        <i class="far fa-star"></i>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Comment -->
                    <div class="mb-4">
                        <label for="comment" class="form-label">Your Review</label>
                        <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="5" placeholder="Share your experience..." required>{{ old('comment') }}</textarea>
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Submit Review
                        </button>
                        <a href="{{ isset($event) ? route('client.events.show', $event->id) : (isset($destination) ? route('destinations.show', $destination->id) : route('client.reviews')) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Review Guidelines</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6><i class="fas fa-check-circle text-success me-2"></i>Helpful Reviews Include:</h6>
                    <ul class="text-muted">
                        <li>Specific details about your experience</li>
                        <li>What you enjoyed or didn't enjoy</li>
                        <li>Honest, constructive feedback</li>
                        <li>Whether you would recommend this event</li>
                    </ul>
                </div>
                
                <div>
                    <h6><i class="fas fa-times-circle text-danger me-2"></i>Please Avoid:</h6>
                    <ul class="text-muted">
                        <li>Offensive language or personal attacks</li>
                        <li>Sharing personal information</li>
                        <li>Mentioning prices (they can change)</li>
                        <li>Very short, uninformative comments</li>
                    </ul>
                </div>
            </div>
        </div>
        
        @if(isset($event))
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Event Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Event Date:</strong>
                        <p class="text-muted">{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Price:</strong>
                        <p class="text-muted">${{ number_format($event->price, 2) }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p class="text-muted">{{ \Illuminate\Support\Str::limit($event->description, 150) }}</p>
                    </div>
                    
                    <a href="{{ route('client.events.show', $event->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i> View Event
                    </a>
                </div>
            </div>
        @elseif(isset($destination))
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Destination Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Location:</strong>
                        <p class="text-muted">{{ $destination->address }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Category:</strong>
                        <p class="text-muted">{{ $destination->category }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p class="text-muted">{{ \Illuminate\Support\Str::limit($destination->description, 150) }}</p>
                    </div>
                    
                    <a href="{{ route('destinations.show', $destination->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i> View Destination
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .rating-star {
        cursor: pointer;
        color: #ccc;
    }
    
    .rating-star:hover i,
    .rating-star:hover ~ label i {
        color: #FFD700;
    }
    
    input[name="rating"]:checked + label i,
    input[name="rating"]:checked ~ label i {
        color: #FFD700;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ratingStars = document.querySelectorAll('.rating-star');
        const ratingInputs = document.querySelectorAll('input[name="rating"]');
        
        ratingStars.forEach(star => {
            star.addEventListener('click', function() {
                const ratingValue = this.previousElementSibling.value;
                
                // Update stars appearance
                ratingStars.forEach(s => {
                    s.querySelector('i').className = 'far fa-star';
                });
                
                // Fill in stars up to the selected one
                for (let i = 0; i < ratingStars.length; i++) {
                    if (ratingInputs[i].value <= ratingValue) {
                        ratingStars[i].querySelector('i').className = 'fas fa-star text-warning';
                    }
                }
            });
        });
    });
</script>
@endpush