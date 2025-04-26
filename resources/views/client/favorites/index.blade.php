@extends('client.dashboard')

@section('dashboard-title', 'My Favorite Destinations')
@section('dashboard-breadcrumb', 'Favorites')

@section('dashboard-actions')
<a href="{{ route('destinations.index') }}" class="btn btn-primary">
    <i class="fas fa-search me-1"></i> Explore More Places
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

<!-- Filter Section -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form action="{{ route('client.favorites') }}" method="GET">
                <input type="hidden" name="view" value="grid">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" name="search" placeholder="Search by name or location..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
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
                    <select class="form-select" name="sort">
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date Added (Oldest)</option>
                        <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date Added (Newest)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
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

<!-- Favorites Grid -->
<div class="row g-4">
    @forelse($favorites as $favorite)
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="position-relative">
                    <div style="height: 180px; overflow: hidden;">
                        <img src="{{ $favorite->image_url ?? 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800' }}" 
                            alt="{{ $favorite->name }}" class="img-fluid w-100" style="object-fit: cover; height: 100%;">
                    </div>
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-favorite-btn" 
                        data-id="{{ $favorite->id }}" data-name="{{ $favorite->name }}">
                        <i class="fas fa-heart-broken"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $favorite->name }}</h5>
                        <span class="badge bg-info">{{ $favorite->category }}</span>
                    </div>
                    <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt me-1"></i> {{ $favorite->address }}</p>
                    <p class="card-text mb-3">{{ \Illuminate\Support\Str::limit($favorite->description, 100) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('destinations.show', $favorite->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                        <a href="https://www.google.com/maps?q={{ $favorite->coordinates }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-map-marked-alt me-1"></i> Map
                        </a>
                    </div>
                </div>
                

            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-heart fa-4x text-muted mb-3"></i>
                    <h4>No Favorites Yet</h4>
                    <p class="text-muted mb-4">You haven't added any destinations to your favorites yet.</p>
                    <a href="{{ route('destinations.index') }}" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Explore Destinations
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if(method_exists($favorites, 'links') && $favorites->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $favorites->appends(request()->query())->links() }}
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

<!-- Success Toast -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
    <div id="successToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Destination removed from favorites successfully.
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the shared modal
        const modal = new bootstrap.Modal(document.getElementById('removeFavoriteModal'));
        const form = document.getElementById('removeFavoriteForm');
        const nameElement = document.getElementById('favoriteNamePlaceholder');
        const successToast = new bootstrap.Toast(document.getElementById('successToast'));
        
        // Add listeners to all remove buttons
        document.querySelectorAll('.remove-favorite-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                
                // Set the destination name in the modal
                nameElement.textContent = name;
                
                // Update the form action
                form.action = `{{ route('client.favorites.remove', '') }}/${id}`;
                
                // Show the modal
                modal.show();
            });
        });
        
        // Handle form submission via AJAX
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get the favoriteId from the action URL
            const url = this.action;
            const favoriteId = url.substring(url.lastIndexOf('/') + 1);
            
            // Create form data
            const formData = new FormData(this);
            
            // Send AJAX request
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
                    // Hide the modal
                    modal.hide();
                    
                    // Remove the card from the DOM
                    const card = document.querySelector(`.remove-favorite-btn[data-id="${favoriteId}"]`).closest('.col-lg-4');
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.8)';
                    
                    setTimeout(() => {
                        card.remove();
                        
                        // Show success toast
                        successToast.show();
                        
                        // If no favorites left, reload to show empty state
                        if (document.querySelectorAll('.remove-favorite-btn').length === 0) {
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