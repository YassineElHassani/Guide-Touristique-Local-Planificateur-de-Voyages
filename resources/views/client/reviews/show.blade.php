@extends('client.dashboard')

@section('dashboard-title', 'Review Details')
@section('dashboard-breadcrumb', 'View Review')

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
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Review Details</h5>
                <div class="btn-group">
                    <a href="{{ route('client.reviews.edit', $review->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteReviewModal">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-3">
                        @if($review->event && $review->event->image)
                            <img src="{{ asset('storage/' . $review->event->image) }}" class="rounded me-3" width="80" height="80" alt="{{ $review->event->name }}" style="object-fit: cover;">
                        @elseif($review->destination && $review->destination->image)
                            <img src="{{ asset('storage/' . $review->destination->image) }}" class="rounded me-3" width="80" height="80" alt="{{ $review->destination->name }}" style="object-fit: cover;">
                        @else
                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-calendar-alt text-secondary fa-2x"></i>
                            </div>
                        @endif
                        <div>
                            <h4 class="mb-0">
                                @if($review->event)
                                    {{ $review->event->name }}
                                @elseif($review->destination)
                                    {{ $review->destination->name }}
                                @else
                                    Unknown
                                @endif
                            </h4>
                            <p class="text-muted mb-0">
                                <i class="fas fa-map-marker-alt me-1"></i> 
                                @if($review->event)
                                    {{ $review->event->location }}
                                @elseif($review->destination)
                                    {{ $review->destination->address }}
                                @else
                                    Unknown Location
                                @endif
                            </p>
                            <div class="mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                                <span class="text-muted ms-2">Posted on {{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="review-content p-4 bg-light rounded mt-3">
                        <p class="mb-0">{{ $review->comment }}</p>
                    </div>
                </div>
                
                <div class="mt-4 pt-3 border-top">
                    <h6 class="mb-3">Review Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="text-muted me-2">Date Posted:</div>
                                <div>{{ $review->created_at->format('F d, Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="text-muted me-2">Last Updated:</div>
                                <div>{{ $review->updated_at->format('F d, Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="text-muted me-2">Rating:</div>
                                <div>{{ $review->rating }} / 5</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="text-muted me-2">Type:</div>
                                <div>{{ $review->event_id ? 'Event Review' : 'Destination Review' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white py-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('client.reviews.edit', $review->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit Review
                    </a>
                    @if($review->event)
                        <a href="{{ route('clientevents.show', $review->event->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-eye me-1"></i> View Event
                        </a>
                    @elseif($review->destination)
                        <a href="{{ route('destinations.show', $review->destination->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-eye me-1"></i> View Destination
                        </a>
                    @endif
                    <button type="button" class="btn btn-outline-danger ms-auto" data-bs-toggle="modal" data-bs-target="#deleteReviewModal">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        @if($review->event)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Event Information</h5>
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
                        <strong>Location:</strong>
                        <p class="text-muted">{{ $review->event->location }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p class="text-muted">{{ \Illuminate\Support\Str::limit($review->event->description, 200) }}</p>
                    </div>
                    
                    <a href="{{ route('clientevents.show', $review->event->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i> View Full Event Details
                    </a>
                </div>
            </div>
        @elseif($review->destination)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Destination Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Address:</strong>
                        <p class="text-muted">{{ $review->destination->address }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Category:</strong>
                        <p class="text-muted">{{ $review->destination->category }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Average Rating:</strong>
                        <p class="text-muted">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->destination->average_rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                            ({{ number_format($review->destination->average_rating, 1) }})
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p class="text-muted">{{ \Illuminate\Support\Str::limit($review->destination->description, 200) }}</p>
                    </div>
                    
                    <a href="{{ route('destinations.show', $review->destination->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i> View Full Destination Details
                    </a>
                </div>
            </div>
        @endif
        
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Other Reviews</h5>
            </div>
            <div class="card-body p-0">
                @if(($review->event && $review->event->reviews->count() > 1) || ($review->destination && $review->destination->reviews->count() > 1))
                    <ul class="list-group list-group-flush">
                        @if($review->event)
                            @foreach($review->event->reviews->where('id', '!=', $review->id)->take(3) as $otherReview)
                                <li class="list-group-item px-4 py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div>
                                            <strong>{{ $otherReview->user->name }}</strong>
                                            <small class="text-muted ms-2">{{ $otherReview->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <div>
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $otherReview->rating ? 'text-warning' : 'text-muted' }} small"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="mb-0 small">{{ \Illuminate\Support\Str::limit($otherReview->comment, 100) }}</p>
                                </li>
                            @endforeach
                        @elseif($review->destination)
                            @foreach($review->destination->reviews->where('id', '!=', $review->id)->take(3) as $otherReview)
                                <li class="list-group-item px-4 py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div>
                                            <strong>{{ $otherReview->user->name }}</strong>
                                            <small class="text-muted ms-2">{{ $otherReview->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <div>
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $otherReview->rating ? 'text-warning' : 'text-muted' }} small"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="mb-0 small">{{ \Illuminate\Support\Str::limit($otherReview->comment, 100) }}</p>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="card-footer bg-white py-3 text-center">
                        @if($review->event)
                            <a href="{{ route('client.events.show', $review->event->id) }}#reviews" class="text-decoration-none">View All Reviews</a>
                        @elseif($review->destination)
                            <a href="{{ route('destinations.show', $review->destination->id) }}#reviews" class="text-decoration-none">View All Reviews</a>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-comments text-muted fa-2x mb-2"></i>
                        <p class="mb-0">No other reviews yet.</p>
                    </div>
                @endif
            </div>
        </div>
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
                <p>Are you sure you want to delete your review for 
                @if($review->event)
                    <strong>{{ $review->event->name }}</strong>?
                @elseif($review->destination)
                    <strong>{{ $review->destination->name }}</strong>?
                @else
                    this item?
                @endif
                </p>
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