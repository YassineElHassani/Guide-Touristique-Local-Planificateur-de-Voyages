@extends('admin.layout')

@section('title', 'Review Management')
@section('heading', 'Review Management')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Reviews</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Reviews</h5>
            <form action="{{ route('admin.search') }}" method="GET" class="me-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search reviews..." name="query">
                    <input type="hidden" name="type" value="reviews">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Item</th>
                            <th>Rating</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td>{{ $review->id }}</td>
                                <td>
                                    @if($review->user)
                                        <a href="{{ route('admin.users.show', $review->user->id) }}">
                                            {{ $review->user->first_name }} {{ $review->user->last_name }}
                                        </a>
                                    @else
                                        <span class="text-muted">Deleted User</span>
                                    @endif
                                </td>
                                <td>
                                    @if($review->destination_id)
                                        <span class="badge bg-primary">Destination</span>
                                    @elseif($review->event_id)
                                        <span class="badge bg-success">Event</span>
                                    @endif
                                </td>
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
                                <td>
                                    <div class="d-flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }} small"></i>
                                        @endfor
                                        <span class="ms-1">({{ $review->rating }})</span>
                                    </div>
                                </td>
                                <td>{{ $review->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $review->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $review->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Delete</h5>
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
                                                        <button type="submit" class="btn btn-danger">Delete Review</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                        <h5>No Reviews Found</h5>
                                        <p class="text-muted">There are no reviews in the system yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($reviews) && method_exists($reviews, 'links'))
            <div class="card-footer d-flex justify-content-center">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
@endsection