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
        <form action="#" method="GET">
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

<!-- Favorites Grid -->
<div class="row g-4">
    @forelse($favorites as $favorite)
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="position-relative">
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                        <i class="fas fa-map-marker-alt fa-3x text-secondary"></i>
                    </div>
                    <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" 
                        data-bs-toggle="modal" data-bs-target="#removeFavoriteModal{{ $favorite->id }}">
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
                
                <!-- Remove Favorite Modal -->
                <div class="modal fade" id="removeFavoriteModal{{ $favorite->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Remove from Favorites</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to remove <strong>{{ $favorite->name }}</strong> from your favorites?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('client.favorites.remove', $favorite->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </div>
                        </div>
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

<!-- Pagination if needed -->
@if($favorites->count() > 0 && method_exists($favorites, 'links'))
    <div class="d-flex justify-content-center mt-4">
        {{ $favorites->appends(request()->query())->links() }}
    </div>
@endif

@endsection