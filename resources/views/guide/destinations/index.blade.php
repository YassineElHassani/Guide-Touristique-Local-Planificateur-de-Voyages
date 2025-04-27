@extends('guide.dashboard')

@section('dashboard-title', 'Destinations')
@section('dashboard-breadcrumb', 'Destinations')

@section('dashboard-actions')
    <div class="btn-group">
        <a href="{{ route('guide.destinations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Create New Destination
        </a>
    </div>
@endsection

@section('dashboard-content')
    <!-- Destinations Grid -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Your Destinations</h5>
            <span class="badge bg-primary rounded-pill">{{ $destinations->count() }} Destinations</span>
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
                                </div>
                                
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $destination->location }}
                                </p>
                                
                                <p class="card-text small mb-3">{{ Str::limit($destination->description, 100) }}</p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    @if($destination->category)
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-folder me-1"></i> {{ $destination->category }}
                                        </span>
                                    @endif
                                    
                                    @php
                                        $eventCount = \App\Models\events::where('id', Auth::id())
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
