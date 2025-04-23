@extends('client.dashboard')

@section('dashboard-title', 'Edit Review')
@section('dashboard-breadcrumb', 'Edit Review')

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
                <h5 class="mb-0">Edit Your Review</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('client.reviews.update', $review->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Event Information -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            @if($review->event && $review->event->image)
                                <img src="{{ asset('storage/' . $review->event->image) }}" class="rounded me-3" width="60" height="60" alt="{{ $review->event->name }}" style="object-fit: cover;">
                            @else
                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-calendar-alt text-secondary fa-2x"></i>
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-0">{{ $review->event->name ?? 'Unknown Event' }}</h5>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $review->event->location ?? 'Unknown Location' }}
                                </p>
                                <p class="text-muted mb-0 small">Reviewed on {{ $review->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rating -->
                    <div class="mb-4">
                        <label class="form-label">Rating</label>
                        <div class="rating-input">
                            <div class="d-flex align-items-center">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="visually-hidden" {{ $review->rating == $i ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" class="me-2 fs-3 rating-star">
                                        <i class="fa{{ $review->rating >= $i ? 's' : 'r' }} fa-star {{ $review->rating >= $i ? 'text-warning' : '' }}"></i>
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
                        <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="5" required>{{ old('comment', $review->comment) }}</textarea>
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Review
                        </button>
                        <a href="{{ route('client.reviews') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="button" class="btn btn-outline-danger ms-auto" data-bs-toggle="modal" data-bs-target="#deleteReviewModal">
                            <i class="fas fa-trash me-1"></i> Delete Review
                        </button>
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
        
        @if($review->event)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Event Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Event Date:</strong>
                        <p class="text-muted">{{ \Carbon\Carbon::parse($review->event->date)->format('F d, Y') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Price:</strong>
                        <p class="text-muted">${{ number_format($review->event->price, 2) }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p class="text-muted">{{ \Illuminate\Support\Str::limit($review->event->description, 150) }}</p>
                    </div>
                    
                    <a href="{{ route('events.show', $review->event->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i> View Event
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Review Modal -->
<div class="modal fade" id="deleteReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your review for <strong>{{ $review->event->name ?? 'this event' }}</strong>?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('client.reviews.delete', $review->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Review</button>
                </form>
            </div>
        </div>
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