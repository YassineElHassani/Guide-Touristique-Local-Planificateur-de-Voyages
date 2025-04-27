@extends('guide.dashboard')

@section('dashboard-title', 'Manage Destinations')
@section('dashboard-breadcrumb', 'Destinations')

@section('dashboard-actions')
    <a href="{{ route('guide.destinations.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Create New Destination
    </a>
@endsection

@section('dashboard-content')
    <!-- Search and Filter Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('guide.destinations.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search Destinations</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="search" name="search" 
                            placeholder="Search by name or location" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="">All Categories</option>
                        @foreach(\App\Models\categories::where('user_id', Auth::id())->get() as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label">Sort By</label>
                    <select class="form-select" id="sort" name="sort">
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Destinations Grid -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Your Destinations</h5>
            <span class="badge bg-primary">{{ $destinations->count() }} Destinations</span>
        </div>
        <div class="card-body">
            <div class="row g-4">
                @forelse($destinations as $destination)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            @if($destination->image)
                                <img src="{{ asset('storage/' . $destination->image) }}" class="card-img-top" height="180" style="object-fit: cover;" alt="{{ $destination->name }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <i class="fas fa-map-marker-alt fa-3x text-secondary"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">{{ $destination->name }}</h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('guide.destinations.edit', $destination->id) }}">
                                                    <i class="fas fa-edit me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('guide.destinations.show', $destination->id) }}">
                                                    <i class="fas fa-eye me-2"></i> View Details
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteDestinationModal{{ $destination->id }}">
                                                    <i class="fas fa-trash me-2"></i> Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $destination->location }}
                                </p>
                                
                                <p class="card-text small mb-3">{{ Str::limit($destination->description, 100) }}</p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    @if($destination->category)
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-folder me-1"></i> {{ $destination->category->name }}
                                        </span>
                                    @endif
                                    
                                    @php
                                        $eventCount = \App\Models\events::where('user_id', Auth::id())
                                            ->where('location', 'like', '%' . $destination->name . '%')
                                            ->count();
                                    @endphp
                                    
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-calendar-alt me-1"></i> {{ $eventCount }} events
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('guide.destinations.show', $destination->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> View Details
                                    </a>
                                    <a href="{{ route('guide.destinations.edit', $destination->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Delete Destination Modal -->
                        <div class="modal fade" id="deleteDestinationModal{{ $destination->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete <strong>{{ $destination->name }}</strong>?</p>
                                        @if($eventCount > 0)
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                This destination is associated with {{ $eventCount }} events. Deleting it may affect those events.
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('guide.destinations.destroy', $destination->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete Destination</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-map-marked-alt fa-4x text-muted mb-3"></i>
                            <h5>No Destinations Found</h5>
                            <p class="text-muted">You haven't created any destinations yet.</p>
                            <a href="{{ route('guide.destinations.create') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus me-1"></i> Create Your First Destination
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        @if($destinations->count() > 0 && $destinations instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer bg-white border-0 py-3">
                {{ $destinations->links() }}
            </div>
        @endif
    </div>
@endsection
