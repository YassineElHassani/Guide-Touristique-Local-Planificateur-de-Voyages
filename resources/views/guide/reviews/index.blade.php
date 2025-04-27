@extends('guide.dashboard')

@section('dashboard-title', 'Manage Reviews')
@section('dashboard-breadcrumb', 'Reviews')

@section('dashboard-content')
    <!-- Reviews Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Overall Rating</h5>
                        <div class="bg-info bg-opacity-10 p-2 rounded">
                            <i class="fas fa-star text-info"></i>
                        </div>
                    </div>
                    
                    @php
                        $avgRating = $reviews->avg('rating') ?? 0;
                    @endphp
                    
                    <div class="d-flex align-items-center mb-2">
                        <h2 class="mb-0 me-2">{{ number_format($avgRating, 1) }}</h2>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($avgRating))
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <p class="text-muted mb-0">Based on {{ $reviews->count() }} reviews</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Rating Distribution</h5>
                        <div class="bg-info bg-opacity-10 p-2 rounded">
                            <i class="fas fa-chart-bar text-info"></i>
                        </div>
                    </div>
                    
                    @php
                        $ratingCounts = [
                            5 => $reviews->where('rating', 5)->count(),
                            4 => $reviews->where('rating', 4)->count(),
                            3 => $reviews->where('rating', 3)->count(),
                            2 => $reviews->where('rating', 2)->count(),
                            1 => $reviews->where('rating', 1)->count(),
                        ];
                        
                        $totalReviews = $reviews->count();
                    @endphp
                    
                    <div class="row">
                        <div class="col-md-8">
                            @for($i = 5; $i >= 1; $i--)
                                @php
                                    $percentage = $totalReviews > 0 ? ($ratingCounts[$i] / $totalReviews) * 100 : 0;
                                @endphp
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-2" style="width: 60px;">
                                        @for($j = 1; $j <= 5; $j++)
                                            @if($j <= $i)
                                                <i class="fas fa-star text-warning small"></i>
                                            @else
                                                <i class="far fa-star text-warning small"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $i >= 4 ? 'success' : ($i >= 3 ? 'warning' : 'danger') }}" 
                                            role="progressbar" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="small">{{ $ratingCounts[$i] }}</span>
                                </div>
                            @endfor
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="mb-2">
                                    <span class="d-inline-block bg-success rounded-circle" style="width: 12px; height: 12px;"></span>
                                    <span class="ms-1">Excellent (4-5)</span>
                                </div>
                                <div class="mb-2">
                                    <span class="d-inline-block bg-warning rounded-circle" style="width: 12px; height: 12px;"></span>
                                    <span class="ms-1">Average (3)</span>
                                </div>
                                <div>
                                    <span class="d-inline-block bg-danger rounded-circle" style="width: 12px; height: 12px;"></span>
                                    <span class="ms-1">Poor (1-2)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Reviews</h5>
            <span class="badge bg-primary">{{ $reviews->count() }} Reviews</span>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse($reviews as $review)
                    <div class="list-group-item p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                @php
                                    $avatar = $review->user && $review->user->picture
                                        ? (Str::startsWith($review->user->picture, 'http')
                                            ? $review->user->picture
                                            : asset('storage/' . $review->user->picture))
                                        : asset('/assets/images/default-avatar.png');
                                @endphp
                                <img src="{{ $avatar }}" class="rounded-circle me-3" width="50" height="50" alt="User">
                                <div>
                                    <h6 class="mb-0">{{ $review->user->first_name ?? 'Guest' }} {{ $review->user->last_name ?? '' }}</h6>
                                    <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <p class="mb-0">{{ $review->comment }}</p>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-light text-dark">
                                    Event: 
                                    @if($review->event)
                                        <a href="{{ route('guide.events.show', $review->event->id) }}" class="text-decoration-none">
                                            {{ $review->event->name }}
                                        </a>
                                    @else
                                        Unknown Event
                                    @endif
                                </span>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#replyModal{{ $review->id }}">
                                    <i class="fas fa-reply me-1"></i> Reply
                                </button>
                            </div>
                        </div>
                        
                        <!-- Reply Modal -->
                        <div class="modal fade" id="replyModal{{ $review->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Reply to Review</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="#" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="reply{{ $review->id }}" class="form-label">Your Reply</label>
                                                <textarea class="form-control" id="reply{{ $review->id }}" name="reply" rows="4" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Submit Reply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center">
                        <i class="fas fa-star fa-3x text-muted mb-3"></i>
                        <h5>No Reviews Found</h5>
                        <p class="text-muted">There are no reviews matching your filters.</p>
                    </div>
                @endforelse
            </div>
        </div>
        @if($reviews->count() > 0 && $reviews instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer bg-white border-0 py-3">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
@endsection
