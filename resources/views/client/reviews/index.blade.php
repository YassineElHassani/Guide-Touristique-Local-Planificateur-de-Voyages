@extends('client.dashboard')

@section('dashboard-title', 'My Reviews')
@section('dashboard-breadcrumb', 'Reviews')

@section('dashboard-actions')
    <div class="d-flex">
        <a href="{{ route('client.events.index') }}" class="btn btn-primary me-2">
            <i class="fas fa-search me-1"></i> Find Events to Review
        </a>
    </div>
@endsection

@section('dashboard-content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Reviews Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-secondary bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-star text-secondary fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Reviews</h6>
                            <h3 class="mb-0">{{ $reviews->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-calendar-check text-success fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Reviewed Events</h6>
                            <h3 class="mb-0">{{ $reviews->pluck('event_id')->unique()->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-star-half-alt text-warning fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Avg Rating</h6>
                            <h3 class="mb-0">
                                {{ $reviews->count() > 0 ? number_format($reviews->avg('rating'), 1) : 'N/A' }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-calendar-alt text-info fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Latest Review</h6>
                            <h3 class="mb-0">
                                {{ $reviews->count() > 0 ? $reviews->sortByDesc('created_at')->first()->created_at->format('M d') : 'None' }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form action="{{ route('client.reviews') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" placeholder="Search by event name..."
                                value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="rating">
                            <option value="">All Ratings</option>
                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="sort">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First
                            </option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First
                            </option>
                            <option value="rating_high" {{ request('sort') == 'rating_high' ? 'selected' : '' }}>Highest
                                Rating</option>
                            <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>Lowest
                                Rating</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">Your Reviews</h5>
        </div>
        <div class="card-body p-0">
            @forelse($reviews as $review)
                <div class="review-item p-4 border-bottom">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-3">
                                @if ($review->event && $review->event->image)
                                    <img src="{{ asset('storage/' . $review->event->image) }}" class="rounded me-3"
                                        width="60" height="60" alt="{{ $review->event->name }}"
                                        style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                        style="width: 60px; height: 60px;">
                                        <i class="fas fa-calendar-alt text-secondary fa-2x"></i>
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-0">{{ $review->event->name ?? 'Unknown Event' }}</h5>
                                    <p class="text-muted mb-0 small">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $review->event->location ?? 'Unknown Location' }}
                                    </p>
                                    <div class="mt-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                        <span class="text-muted ms-1">{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-0">{{ $review->comment }}</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="d-flex flex-column">
                            <div class="d-flex mb-2" style="gap: 5px;">
                                <a href="{{ route('client.reviews.edit', $review->id) }}" class="btn btn-sm btn-outline-primary flex-grow-1 d-flex justify-content-center align-items-center">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>

                                <form action="{{ route('client.reviews.delete', $review->id) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100"><i class="fas fa-trash me-1"></i> Delete</button>
                                </form>
                            </div>

                            @if ($review->event)
                                <a href="{{ route('client.events.show', $review->event->id) }}"
                                    class="btn btn-sm btn-outline-secondary w-100">
                                    <i class="fas fa-eye me-1"></i> View Event
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                    <h4>No Reviews Yet</h4>
                    <p class="text-muted mb-4">You haven't written any reviews yet.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('client.events.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Find Events to Review
                        </a>
                        <a href="{{ route('client.reviews.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-star me-1"></i> Write a Review
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($reviews->count() > 0 && method_exists($reviews, 'links'))
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-center">
                    {{ $reviews->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>

@endsection