@extends('client.dashboard')

@section('dashboard-title', 'My Favorite Places')
@section('dashboard-breadcrumb', 'Favorites')

@section('dashboard-actions')
<a href="{{ route('destinations.index') }}" class="btn btn-primary">
    <i class="fas fa-map-marked-alt me-1"></i> Explore Destinations
</a>
@endsection

@push('styles')
<style>
    .favorite-item {
        transition: all 0.3s ease;
    }
    
    .favorite-item:hover {
        transform: translateY(-5px);
    }
    
    .favorite-img {
        height: 160px;
        object-fit: cover;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    
    .favorite-badge {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    
    .favorite-actions {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.6);
        padding: 8px;
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .favorite-item:hover .favorite-actions {
        opacity: 1;
    }
    
    .rating {
        color: #ffc107;
    }
    
    .empty-state {
        padding: 60px 20px;
        text-align: center;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }
    
    .empty-state h4 {
        color: #6c757d;
        margin-bottom: 1rem;
    }
    
    .category-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 10;
    }
    
    .favorite-remove-confirm {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
        width: 300px;
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s ease;
    }
    
    .favorite-remove-confirm.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('dashboard-content')
<!-- Alerts -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Favorite Remove Confirmation Toast -->
<div class="toast favorite-remove-confirm" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
    <div class="toast-header bg-success text-white">
        <i class="fas fa-check-circle me-2"></i>
        <strong class="me-auto">Success</strong>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        Destination removed from favorites successfully.
    </div>
</div>

<!-- View Switcher -->
<div class="d-flex justify-content-end mb-4">
    <div class="btn-group" role="group" aria-label="View options">
        <a href="{{ route('client.favorites', array_merge(request()->except('view', 'page'), ['view' => 'grid'])) }}" 
            class="btn btn-outline-primary {{ request('view', 'grid') != 'list' ? 'active' : '' }}">
            <i class="fas fa-th-large me-1"></i> Grid View
        </a>
        <a href="{{ route('client.favorites', array_merge(request()->except('view', 'page'), ['view' => 'list'])) }}" 
            class="btn btn-outline-primary {{ request('view') == 'list' ? 'active' : '' }}">
            <i class="fas fa-list me-1"></i> List View
        </a>
    </div>
</div>

<!-- Filter & Sort Options -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('client.favorites') }}" method="GET" class="row g-3 align-items-end">
                <input type="hidden" name="view" value="list">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" name="search" placeholder="Search by name or location" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Category</label>
                <select class="form-select" name="category">
                    <option value="">All Categories</option>
                    @php
                        $categories = \App\Models\categories::all();
                    @endphp
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Sort By</label>
                <select class="form-select" name="sort">
                    <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date Added (Newest)</option>
                    <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date Added (Oldest)</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                    <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Rating (Highest)</option>
                    <option value="rating_asc" {{ request('sort') == 'rating_asc' ? 'selected' : '' }}>Rating (Lowest)</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-2"></i> Apply
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Favorites List -->
@if($favorites->count() > 0)
    <div class="row g-4">
        @foreach($favorites as $favorite)
            <div class="col-lg-4 col-md-6" id="favorite-item-{{ $favorite->id }}">
                <div class="card h-100 border-0 shadow-sm favorite-item">
                    <div class="position-relative">
                        <span class="badge bg-info category-badge">{{ $favorite->category }}</span>
                        <img src="{{ $favorite->image_url ?? 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800' }}" 
                            alt="{{ $favorite->name }}" class="card-img-top favorite-img">
                        <div class="favorite-actions d-flex justify-content-end">
                            <a href="{{ route('destinations.show', $favorite->id) }}" class="btn btn-sm btn-light me-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="https://www.google.com/maps?q={{ $favorite->coordinates }}" target="_blank" class="btn btn-sm btn-light me-2">
                                <i class="fas fa-map-marker-alt"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger remove-favorite" data-id="{{ $favorite->id }}" data-name="{{ $favorite->name }}">
                                <i class="fas fa-heart-broken"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-1">{{ $favorite->name }}</h5>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-map-marker-alt me-1"></i> {{ $favorite->address }}
                        </p>
                        <div class="mb-2">
                            @php
                                $rating = $favorite->average_rating ?? 4.5;
                                $fullStars = floor($rating);
                                $halfStar = $rating - $fullStars >= 0.5;
                            @endphp
                            
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $fullStars)
                                        <i class="fas fa-star"></i>
                                    @elseif($halfStar && $i == $fullStars + 1)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span class="ms-1 text-muted small">{{ $rating }}</span>
                            </div>
                        </div>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($favorite->description, 80) }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="far fa-clock me-1"></i> Added {{ \Carbon\Carbon::parse($favorite->created_at)->diffForHumans() }}
                        </small>
                        <a href="{{ route('destinations.show', $favorite->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    @if(method_exists($favorites, 'links') && $favorites->count() > 0)
        <div class="d-flex justify-content-center mt-4">
            {{ $favorites->appends(request()->query())->links() }}
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="empty-state">
        <i class="far fa-heart"></i>
        <h4>No Favorites Yet</h4>
        <p class="text-muted mb-4">You haven't added any destinations to your favorites list. Start exploring to find places you love!</p>
        <a href="{{ route('destinations.index') }}" class="btn btn-primary">
            <i class="fas fa-compass me-2"></i> Explore Destinations
        </a>
    </div>
@endif

<!-- Shared Remove Favorite Modal -->
<div class="modal fade" id="removeFavoriteModal" tabindex="-1" aria-labelledby="removeFavoriteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeFavoriteModalLabel">Remove from Favorites</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove <strong id="favoriteNamePlaceholder"></strong> from your favorites?</p>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="removeFavoriteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Remove</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize modal and toast
        const modal = new bootstrap.Modal(document.getElementById('removeFavoriteModal'));
        const form = document.getElementById('removeFavoriteForm');
        const nameElement = document.getElementById('favoriteNamePlaceholder');
        const toast = new bootstrap.Toast(document.querySelector('.favorite-remove-confirm'));
        
        // Add listeners to all remove buttons
        document.querySelectorAll('.remove-favorite').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                
                // Update modal content
                nameElement.textContent = name;
                form.action = `{{ route('client.favorites.remove', '') }}/${id}`;
                
                // Show modal
                modal.show();
            });
        });
        
        // Handle form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const url = this.action;
            const favoriteId = url.substring(url.lastIndexOf('/') + 1);
            const formData = new FormData(this);
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide modal
                    modal.hide();
                    
                    // Remove card with animation
                    const element = document.getElementById('favorite-item-' + favoriteId);
                    element.style.opacity = '0';
                    element.style.transform = 'scale(0.8)';
                    
                    setTimeout(() => {
                        element.remove();
                        toast.show();
                        
                        // Check if we need to show empty state
                        if (document.querySelectorAll('.favorite-item').length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>
@endpush
@endsection