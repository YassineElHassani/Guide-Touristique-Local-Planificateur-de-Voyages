@extends('admin.layout')

@section('title', 'Review Details')
@section('heading', 'Review Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
    <li class="breadcrumb-item active" aria-current="page">Review #{{ $review->id }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Review Information</h5>
                    <div class="d-flex">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-light">
                                <p class="mb-0 font-italic">{{ $review->comment }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <h5 class="border-bottom pb-2 mb-3">Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th style="width: 40%">Review ID</th>
                                    <td>{{ $review->id }}</td>
                                </tr>
                                <tr>
                                    <th>Rating</th>
                                    <td>{{ $review->rating }} / 5</td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td>{{ $review->created_at->format('M d, Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $review->updated_at->format('M d, Y, H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th style="width: 40%">User</th>
                                    <td>
                                        @if($review->user)
                                            <a href="{{ route('admin.users.show', $review->user->id) }}">
                                                {{ $review->user->first_name }} {{ $review->user->last_name }}
                                            </a>
                                        @else
                                            <span class="text-muted">Deleted User</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Review Type</th>
                                    <td>
                                        @if($review->destination_id)
                                            <span class="badge bg-primary">Destination</span>
                                        @elseif($review->event_id)
                                            <span class="badge bg-success">Event</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Related Item</th>
                                    <td>
                                        @if($review->destination_id && $review->destination)
                                            <a href="{{ route('admin.destinations.show', $review->destination_id) }}">
                                                {{ $review->destination->name }}
                                            </a>
                                        @elseif($review->event_id && $review->event)
                                            <a href="{{ route('admin.events.show', $review->event_id) }}">
                                                {{ $review->event->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">Deleted Item</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteReviewModal">
                            <i class="fas fa-trash me-2"></i>Delete Review
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">User Information</h5>
                </div>
                <div class="card-body">
                    @if($review->user)
                        <div class="text-center mb-3">
                            @php
                                $avatar = $review->user->picture
                                    ? (Str::startsWith($review->user->picture, 'http')
                                        ? $review->user->picture
                                        : asset('storage/' . $review->user->picture))
                                    : asset('/assets/images/default-avatar.png');
                            @endphp
                            <img src="{{ $avatar }}" alt="{{ $review->user->first_name }}" class="rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                            <h5>{{ $review->user->first_name }} {{ $review->user->last_name }}</h5>
                            <p class="text-muted mb-0">{{ $review->user->email }}</p>
                            <p class="mb-0">
                                <span class="badge bg-{{ $review->user->role === 'admin' ? 'danger' : ($review->user->role === 'guide' ? 'success' : 'primary') }}">
                                    {{ ucfirst($review->user->role) }}
                                </span>
                            </p>
                        </div>
                        
                        <div class="mb-2">
                            <strong>Total Reviews:</strong>
                            <p class="mb-0">{{ \App\Models\reviews::where('user_id', $review->user->id)->count() }} reviews</p>
                        </div>
                        
                        <div class="d-grid">
                            <a href="{{ route('admin.users.show', $review->user->id) }}" class="btn btn-outline-secondary btn-sm">
                                View User Profile
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-exclamation-triangle text-warning fa-2x mb-2"></i>
                            <p class="mb-0">User account has been deleted.</p>
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
                    <h5 class="modal-title text-danger">Delete Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this review?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Permanently</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection